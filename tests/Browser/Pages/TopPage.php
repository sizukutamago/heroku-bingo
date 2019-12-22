<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class TopPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param \Laravel\Dusk\Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser
            ->assertSee('ビンビンビンゴ！！！')
            ->assertSee('ビンゴルームを作成！');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    // todo: bignoLobbyPageに移動した方がいい気がする
    public function createBingoRoom(Browser $browser)
    {
        $browser->click('form > .btn');
    }
}
