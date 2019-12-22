<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class BingoLobbyPage extends Page
{
    private $topPage;

    public function __construct()
    {
        $this->topPage = new TopPage;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/room';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
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

    public function accessBingoLobby(Browser $browser) {
        return $browser->visit($this->topPage)
            ->createBingoRoom()
            ->assertSee('ビンゴ開始！');
    }

    public function getToBingoCardLink(Browser $browser) {
        return $this->accessBingoLobby($browser)
            ->element('a.qr')
            ->getAttribute('innerHTML');
    }
}
