<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class CommunicationsPage extends Page
{
    /** Get the URL for the page. */
    public function url(): string
    {
        return '/admin/communications';
    }

    /** Create new communication. */
    public function createNewCommunication(Browser $browser): void
    {
        $browser->press('Nuevo Comunicado')
                ->waitForText('Crear Comunicado');
    }

    /** Fill in the communication's data. */
    public function fillCommunicationData(Browser $browser, $title, $message, $status, $sendDate, $course = null, $ageFrom = null, $ageTo = null): void
    {
        $browser->type('#title', $title)
                ->type('#message', $message)
                ->select('#status', $status)
                ->type('#send_date', $sendDate);
        if ($course) {
            $browser->select('#course_id', $course);
        }
            
        if ($ageFrom) {
            $browser->type('#age_from', $ageFrom);
        }
            
        if ($ageTo) {
            $browser->type('#age_to', $ageTo);
        }
    }

    /** Save the communication. */
    public function saveCommunication(Browser $browser): void
    {
        $browser->press('Guardar');
    }

    /** Create and save a new communication with provided data. */
    public function createFullCommunication(Browser $browser, $title, $message, $status, $sendDate): void
    {
        $this->createNewCommunication($browser);
        $this->fillCommunicationData($browser, $title, $message, $status, $sendDate);
        $this->saveCommunication($browser);
    }

    /** Assert that the communication was created */
    public function assertCommunicationCreated(Browser $browser): void
    {
        $browser->waitFor('@alert', 5)
                ->assertSeeIn('@alert', 'Comunicado creado correctamente.');
    }

    /** Assert communication status */
    public function assertCommunicationStatus(Browser $browser, $expectedTitle, $expectedStatus): void
    {
        $browser->with("table tbody", function ($tbody) use ($expectedTitle, $expectedStatus) {
            $tbody->assertSee($expectedTitle);
            $tbody->assertSee($expectedStatus);
        });
    }

    /** Edit communication. */
    public function editCommunicationFromTitle(Browser $browser, $originalTitle, $newTitle, $newMessage, $newStatus, $newDate): self
    {
        // Find the specific title and click on its edit button
        $browser->with("table tbody", function ($tbody) use ($originalTitle) {
            // Find the edit button associated with the specific title
            $tbody->with("tr", function ($row) use ($originalTitle) {
                $row->assertSee($originalTitle)
                    ->press('Editar');
            });
        });
    
        // Wait for the modal to load (because of the title, which does appear)
        $browser->waitForText('Editar Comunicado', 5);

        // Fill in the fields of the editing form
        $browser->type('#title', $newTitle)
                ->type('#message', $newMessage)
                ->select('#status', $newStatus)
                ->type('#send_date', $newDate)
                ->press('Actualizar');
        
        return $this;
    }

    public function assertCommunicationEdited(Browser $browser): void
    {
        $browser->waitFor('@alert', 5)
                ->assertSeeIn('@alert', 'Comunicado actualizado correctamente.');
    }


    /**
     * Get the global element shortcuts for the site.
     *
     * @return array<string, string>
     */
    public static function siteElements(): array
    {
        return [
            '@alert' => '.bg-green-100.border-green-400.text-green-700',
        ];
    }
}