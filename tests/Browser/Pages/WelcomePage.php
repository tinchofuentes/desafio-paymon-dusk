<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class WelcomePage extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/';
    }

    /**
     * Assert that the browser is on the welcome page.
     */
    public function assertTitleOnWelcomePage(Browser $browser): void
    {
        $browser->assertSeeIn('@page-title', 'Nuestra Oferta Académica');
    }

    public function clickFirstEnrollButton(Browser $browser)
    {
        $browser->with('@first-course-card', function ($card) {
            $card->clickLink('Enroll Now');
        });
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@page-title' => 'h2',
            '@first-course-card' => '.bg-gray-50:first-child',
        ];
    }
}
