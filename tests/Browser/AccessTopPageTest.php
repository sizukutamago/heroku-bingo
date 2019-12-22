<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\TopPage;
use Tests\DuskTestCase;

class AccessTopPageTest extends DuskTestCase
{
    /**
     * @test
     */
    public function トップページにアクセス()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new TopPage())->assert();
        });
    }
}
