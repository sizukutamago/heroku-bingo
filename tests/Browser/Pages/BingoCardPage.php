<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class BingoCardPage extends Page
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

    public function accessBingoCardPage(Browser $browser, string $bingoCardUrl) {
        return $browser->visit($bingoCardUrl)
            ->assertSee('ニックネームを決めてビンゴ開始！')
            ->type('username', 'testUser')
            ->click('form > .btn')
            ->assertSourceHas('src="/img/bingo.jpg"')
            ->assertSourceHas('src="/img/heroku-logo.png"');
    }
}
