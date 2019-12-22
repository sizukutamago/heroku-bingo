<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\BingoLobbyPage;
use Tests\Browser\Pages\TopPage;
use Tests\DuskTestCase;

class AccessBingoRouletteTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function ビンゴルーレットページにアクセス()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new BingoLobbyPage)
                ->accessBingoLobby()
                ->click('form > .btn');

            // _blackで別タブで開くため最後に開いたタブに遷移する
            $window = collect($browser->driver->getWindowHandles())->last();
            $browser->driver->switchTo()->window($window);
            $browser->assertSee('ルーレット！');
        });
    }
}
