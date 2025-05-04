<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class EnrollConfirmationPage extends Page
{
    /** Get the URL for the page. */
    public function url(): string
    {
        return '/enrollments/1/confirmation';
    }

    /** Assert that the browser is on the confirmation page. */
    public function assertOnConfirmationPage(Browser $browser): void
    {
        $browser->assertSee('¡Inscripción Exitosa!');
        $browser->assertSee('Gracias por inscribirte en nuestro curso.');
    }

    /** Verify enrollment details are correct. */
    public function verifyEnrollmentDetails(Browser $browser, $studentName, $courseName, $academyName, $enrollmentDate): void
    {
        // Wait until the student's text appears
        $browser->assertSee("$studentName")
                ->assertSee("$courseName")
                ->assertSee("$academyName")
                ->assertSee("$enrollmentDate");
    }

    /** Verify payment details are correct. */
    public function verifyPaymentDetails(Browser $browser, $amount, $paymentMethod, $paymentStatus, $referenceNumber): void
    {
        $browser->assertSee("$amount")
                ->assertSee("$paymentMethod")
                ->assertSee("$paymentStatus")
                ->assertSee("$referenceNumber");
    }

    /** Verify the email message. */
    public function verifyEmailMessage(Browser $browser, $guardianEmail): void
    {
        $browser->assertSee("Hemos enviado un correo electrónico con los detalles de la inscripción a $guardianEmail");
    }

    /** Click on "Volver al inicio" to go back to the home page. */
    public function goBackToHome(Browser $browser)
    {
        $browser->clickLink('Volver al inicio');
    }

    /**
     * Get the global element shortcuts for the site.
     *
     * @return array<string, string>
     */
    public static function siteElements(): array
    {
        return [
            '@page-title' => 'h2',
        ];
    }
}
