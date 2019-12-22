<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TopTest extends DuskTestCase
{
    /**
     * @test
     */
    public function topページにアクセスした時()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('ビンビンビンゴ！！！')
                    ->assertSee('ビンゴルームを作成！');
        });
    }
}
