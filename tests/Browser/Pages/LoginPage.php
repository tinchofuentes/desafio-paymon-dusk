<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class LoginPage extends Page
{
    /** Get the URL for the page. */
    public function url(): string
    {
        return '/login';
    }

    /** Assert that the browser is on the enroll course page. */
    public function loginAs(Browser $browser, $email, $password): void
    {
        $browser->type('#email', $email)
                ->type('#password', $password)
                ->press('LOG IN');
    }

    /**
     * Get the global element shortcuts for the site.
     *
     * @return array<string, string>
     */
    public static function siteElements(): array
    {
        return [
            '@element' => 'selector',
        ];
    }
}
