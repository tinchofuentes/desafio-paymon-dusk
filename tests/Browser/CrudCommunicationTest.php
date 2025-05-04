<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Artisan;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\WelcomePage;
use Tests\Browser\Pages\RegisterPage;
use Tests\Browser\Pages\CommunicationsPage;

class CrudCommunicationTest extends DuskTestCase
{
    public function test_creating_communication_scheduled(): void
    {
        $this->browse(function (Browser $browser) {

            // Reset and seed the database
            Artisan::call('migrate:fresh --seed');

            // Open the app on the home page
            $browser->visit(new WelcomePage)
                    ->assertTitleOnWelcomePage();

            // Click on the "Registrarse" link in the navbar and verify that it redirects to Login.
            $browser->clickLink('Registrarse')
                    ->waitForLocation('/register')
                    ->assertPathIs('/register');

            /** Complete the register form with the provided data and submit */
            $browser->visit(new RegisterPage)
                    ->registerAs('Usuario Prueba', 'user@test.com', '12345678')
                    ->waitForLocation('/admin/communications')
                    ->screenshot('after-register-1');

            // Verify that we are on the communications page
            $browser->visit(new CommunicationsPage)
                    ->assertPathIs('/admin/communications');

            // Create and save a new communication with the status "Programado"
            $browser->createFullCommunication('Bienvenida al nuevo curso', 'Estimados estudiantes, les damos la bienvenida al curso de Algebra I.', 'scheduled', '15-05-2025')
                    ->waitForText('Gestión de Comunicados', 5)
                    ->screenshot('created');

            // Assert that the communication was created
            $browser->assertCommunicationCreated();
            $browser->assertCommunicationStatus('Bienvenida al nuevo curso', 'Programado');

        });
    }

    public function test_editing_existing_communication(): void
    {
        $this->browse(function (Browser $browser) {

            // Reset and seed the database
            Artisan::call('migrate:fresh --seed');

            // Open the app on the home page
            $browser->visit(new WelcomePage)
                    ->assertTitleOnWelcomePage();

            // Click on the "Registrarse" link in the navbar and verify that it redirects to Login.
            $browser->clickLink('Registrarse')
                    ->waitForLocation('/register')
                    ->assertPathIs('/register');

            /** Complete the register form with the provided data and submit */
            $browser->visit(new RegisterPage)
                    ->registerAs('Otro Usuario', 'otheruser@test.com', '87654321')
                    ->waitForLocation('/admin/communications')
                    ->screenshot('after-register-2');

            // Verify that we are on the communications page
            $browser->visit(new CommunicationsPage)
                    ->assertPathIs('/admin/communications');

            // Edit an existing communication
            $browser->editCommunicationFromTitle('Comunicado de prueba para edición', 'Título editado', 'Mensaje editado', 'sent', '12-05-2025')
                    ->waitForText('Gestión de Comunicados', 5)
                    ->screenshot('edited');

            // Assert that the communication was created
            $browser->assertCommunicationEdited();
            $browser->assertCommunicationStatus('Título editado', 'Enviado');

        });
    }

}