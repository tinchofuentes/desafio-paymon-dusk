<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class RegisterPage extends Page
{
    /** Get the URL for the page. */
    public function url(): string
    {
        return '/register';
    }

    /** Assert that the browser is on the enroll course page. */
    public function registerAs(Browser $browser, $name, $email, $password): void
    {
        $browser->type('#name', $name)
                ->type('#email', $email)
                ->type('#password', $password)
                ->type('#password_confirmation', $password)
                ->press('REGISTER');
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
