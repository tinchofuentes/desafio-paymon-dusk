<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class EnrollCoursePage extends Page
{
    /** Get the URL for the page. */
    public function url(): string
    {
        return '/enrollments/create/1';
    }

    /** Assert that the browser is on the enroll course page. */
    public function assertTitleOnEnrollCoursePage(Browser $browser): void
    {
        $browser->assertSeeIn('@page-title', 'Inscripción a Curso');
    }

    /** Fill in the guardian's data. */
    public function fillGuardianData(Browser $browser, $name, $email, $phone): void
    {
        $browser->type('#guardian_name', $name)
                ->type('#guardian_email', $email)
                ->type('#guardian_phone', $phone);
    }

    /** Go to the next step in the enrollment process. */
    public function goToNextStep(Browser $browser): void
    {
        $browser->press('Siguiente');
    }

    /** Fill in the student's data. */
    public function fillStudentData(Browser $browser, $firstName, $lastName, $birthDate, $gender): void
    {
        $browser->waitFor('#student_first_name', 5)  // espera hasta 5 segundos que aparezca el campo
                ->type('#student_first_name', $firstName)
                ->type('#student_last_name', $lastName)
                ->type('#student_birth_date', $birthDate)
                ->select('#student_gender', $gender);
    }

    /**
     * Assert that the Enrollment Summary section is displayed.
     */
    public function assertRegistrationSummary(Browser $browser): void
    {
        $browser->assertSee('Resumen de la inscripción');
    }

    /**
     * Assert that the Payment Information section is displayed.
     */
    public function assertPaymentInformation(Browser $browser): void
    {
        $browser->assertSee('Información de Pago');
    }

    /** Fill in the payment method details. */
    public function fillPaymentInfo(Browser $browser, $paymentMethod, $referenceNumber = null): void
    {
        // Wait for the payment method field to be present and visible
        $browser->waitFor('#payment_method', 5)
                ->select('#payment_method', $paymentMethod);

        // If it is a bank transfer, wait and then fill in the reference number
        if ($paymentMethod === 'bank_transfer') {
            $browser->waitFor('#reference_number', 5)
                    ->type('#reference_number', $referenceNumber);
        }
    }

    /** Submit the enrollment form. */
    public function submitEnrollment(Browser $browser): void
    {
        $browser->press('Completar inscripción');
    }

    // public function completeEnrollmentForm(Browser $browser)
    // {
    //     // Fill in the Guardian's data
    //     $this->fillGuardianData($browser, 'Juan Pérez', 'juan@email.com', '1234567890');
    //     // Go to the next form
    //     $this->goToNextStep($browser);
    //     // Fill in the student's data
    //     $this->fillStudentData($browser, 'Juan Cruz', 'Pérez González', '01-05-2010', 'male');
    //     // Go to the next form
    //     $this->goToNextStep($browser);
    //     // Verify that the Registration Summary and Payment Information sections are displayed.
    //     $this->assertRegistrationSummary($browser);
    //     $this->assertPaymentInformation($browser);
    //     // Fill in the payment information
    //     $this->fillPaymentInfo($browser, 'bank_transfer', '3A5E6F');
    //     // Complete enrollment
    //     $this->submitEnrollment($browser);
    // }
    
    public function completeEnrollmentForm(Browser $browser)
    {
        try {
            // Fill in the Guardian's data
            $this->fillGuardianData($browser, 'Juan Pérez', 'juan@email.com', '1234567890');
            $browser->screenshot('02_guardian-data');
            // Go to the next form
            $this->goToNextStep($browser);
            // Fill in the student's data
            $this->fillStudentData($browser, 'Juan Cruz', 'Pérez González', '01-05-2010', 'male');
            $browser->screenshot('03_student-data');
            // Go to the next form
            $this->goToNextStep($browser);
            // Verify that the Registration Summary and Payment Information sections are displayed.
            $this->assertRegistrationSummary($browser);
            $this->assertPaymentInformation($browser);
            // Fill in the payment information
            $this->fillPaymentInfo($browser, 'bank_transfer', '3A5E6F');
            $browser->screenshot('04_payment-info');
            // Complete enrollment
            $this->submitEnrollment($browser);
            $browser->pause(3000)
                    ->screenshot('05_after-submit');

        } catch (\Exception $e) {
            $browser->screenshot('error_enrollment_flow');
            throw $e; // re-lanzamos la excepción para que el test falle como corresponde
        }
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
