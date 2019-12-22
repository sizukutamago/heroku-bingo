<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
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
}
