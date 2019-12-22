<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\BingoLobbyPage;
use Tests\Browser\Pages\TopPage;
use Tests\DuskTestCase;

class CreateRoomTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $topPage;

    public function setUp(): void
    {
        $this->topPage = new TopPage;
        parent::setUp();
    }

    /**
     * @test
     */
    public function セッションがない状態でルーム作成した時()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->topPage)
                ->createBingoRoom()
                ->assertSee('ビンゴ開始！');
        });
    }

    /**
     * @test
     */
    public function セッションがある状態でルーム作成した時()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->topPage)
                ->createBingoRoom()
                ->visit($this->topPage)
                ->createBingoRoom()
                ->assertSee('すでにルームが存在します');
        });
    }

    /**
     * @test
     */
    public function セッションがある状態でルーム作成し、前回作成したルームに入るリンクを押す()
    {
        $this->browse(function (Browser $browser) {
            $toBingoCardLink = (new BingoLobbyPage)->getToBingoCardLink($browser);

            $browser->visit($this->topPage)
                ->createBingoRoom()
                ->assertSee('すでにルームが存在します')
                ->clickLink('前回作成したルームに入る')
                ->assertSee($toBingoCardLink);
        });
    }

    /**
     * @test
     */
    public function セッションがある状態でルーム作成し、新しく作成するボタンを押す()
    {
        $this->browse(function (Browser $browser) {
            $toBingoCardLink = (new BingoLobbyPage)->getToBingoCardLink($browser);

            $browser->visit($this->topPage)
                ->createBingoRoom()
                ->assertSee('すでにルームが存在します')
                ->click('form > .btn')
                ->assertSee('ビンゴ開始！')
                ->assertDontSee($toBingoCardLink);
        });
    }
}
