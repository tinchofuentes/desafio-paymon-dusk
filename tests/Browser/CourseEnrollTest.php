<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\WelcomePage;
use Tests\Browser\Pages\EnrollCoursePage;
use Tests\Browser\Pages\EnrollConfirmationPage;

class CourseEnrollTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function test_enrollment_flow_for_new_student(): void
    {
        $this->browse(function (Browser $browser) {

            // Reset and seed the database
            Artisan::call('migrate:fresh --seed');

            // Go to the welcome page and click the button to enroll in the first course
            $browser->visit(new WelcomePage)
                    ->assertTitleOnWelcomePage()
                    ->clickFirstEnrollButton()
                    ->screenshot('01_after-click-enroll-now');

            // Verify that we are on the course enrollment page
            $browser->visit(new EnrollCoursePage)
                    ->assertTitleOnEnrollCoursePage()
                    ->completeEnrollmentForm();

            // Verify that we are on the confirmation enrollment page
            $browser->visit(new EnrollConfirmationPage)
                    ->assertOnConfirmationPage();

            // Check enrollment details
            $browser->verifyEnrollmentDetails('Juan Cruz Pérez González', 'Algebra I', 'Mathematics Academy', now()->format('d/m/Y'));

            // Verify payment details
            $browser->verifyPaymentDetails('$150.00', 'bank_transfer', 'pending', '3A5E6F');

            // Verify the final message with the guardian's email
            $browser->verifyEmailMessage('juan@email.com');

            // Verify that the "Volver al inicio" button is present and redirects to the welcome page.
            $browser->goBackToHome()
                    ->assertPathIs('/');
            
        });
    }
}