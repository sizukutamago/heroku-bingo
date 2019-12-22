<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\BingoCardPage;
use Tests\Browser\Pages\BingoLobbyPage;
use Tests\DuskTestCase;

class AccessBingoCardTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function ビンゴカードページに初回アクセス()
    {
        $this->browse(function (Browser $browser) {
            $toBingoCardLink = (new BingoLobbyPage)->getToBingoCardLink($browser);

            (new BingoCardPage)->accessBingoCardPage($browser, $toBingoCardLink);
        });
    }

    /**
     * @test
     */
    public function 同じビンゴカードページに2回目のアクセス()
    {
        $this->browse(function (Browser $browser) {
            $toBingoCardLink = (new BingoLobbyPage)->getToBingoCardLink($browser);

            (new BingoCardPage)->accessBingoCardPage($browser, $toBingoCardLink);

            $browser->visit($toBingoCardLink)
                ->assertDontSee('ニックネームを決めてビンゴ開始！')
                ->assertSourceHas('src="/img/bingo.jpg"')
                ->assertSourceHas('src="/img/heroku-logo.png"');
        });
    }
}
