<?php

namespace Tests\Feature\Livewire\Admin\Communications;

use App\Enums\CommunicationStatus;
use App\Livewire\Admin\Communications\CommunicationForm;
use App\Models\Communication;
use App\Models\Course;
use App\Models\Guardian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CommunicationFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the component renders successfully
     */
    public function test_renders_successfully(): void
    {
        Livewire::test(CommunicationForm::class)
            ->assertOk();
    }

    /**
     * Test that the component can open the create modal
     */
    public function test_can_open_create_modal(): void
    {
        Livewire::test(CommunicationForm::class)
            ->call('create')
            ->assertSet('isOpen', true)
            ->assertSet('editMode', true)
            ->assertSet('viewMode', false)
            ->assertSet('status', CommunicationStatus::DRAFT->value);
    }

    /**
     * Test that the component can create a communication
     */
    public function test_can_create_communication(): void
    {
        $course = Course::factory()->create();

        Livewire::test(CommunicationForm::class)
            ->set('title', 'Test Communication')
            ->set('message', 'This is a test message')
            ->set('course_id', $course->id)
            ->set('age_from', 10)
            ->set('age_to', 15)
            ->set('send_date', now()->format('Y-m-d'))
            ->set('status', CommunicationStatus::DRAFT->value)
            ->call('store')
            ->assertHasNoErrors()
            ->assertDispatched('showMessage')
            ->assertDispatched('refreshParent')
            ->assertDispatched('refreshList');

        $this->assertDatabaseHas('communications', [
            'title' => 'Test Communication',
            'message' => 'This is a test message',
            'course_id' => $course->id,
            'age_from' => 10,
            'age_to' => 15,
        ]);
    }

    /**
     * Test that the component can edit a communication
     */
    public function test_can_edit_communication(): void
    {
        $communication = Communication::factory()->create();

        Livewire::test(CommunicationForm::class)
            ->call('edit', $communication->id)
            ->assertSet('isOpen', true)
            ->assertSet('editMode', true)
            ->assertSet('viewMode', false)
            ->assertSet('communication_id', $communication->id)
            ->assertSet('title', $communication->title)
            ->assertSet('message', $communication->message)
            ->assertSet('course_id', $communication->course_id)
            ->assertSet('age_from', $communication->age_from)
            ->assertSet('age_to', $communication->age_to);
    }

    /**
     * Test that the component can update a communication
     */
    public function test_can_update_communication(): void
    {
        $communication = Communication::factory()->create();
        $course = Course::factory()->create();

        Livewire::test(CommunicationForm::class)
            ->call('edit', $communication->id)
            ->set('title', 'Updated Title')
            ->set('message', 'Updated message')
            ->set('course_id', $course->id)
            ->call('store')
            ->assertHasNoErrors()
            ->assertDispatched('showMessage')
            ->assertDispatched('refreshParent')
            ->assertDispatched('refreshList');

        $this->assertDatabaseHas('communications', [
            'id' => $communication->id,
            'title' => 'Updated Title',
            'message' => 'Updated message',
            'course_id' => $course->id,
        ]);
    }

    /**
     * Test that the component can view a communication
     */
    public function test_can_view_communication(): void
    {
        $course = Course::factory()->create(['active' => true]);

        $communication = Communication::factory()->create([
            'course_id' => $course->id
        ]);
        
        $guardian = Guardian::factory()->create();
        $communication->guardians()->attach($guardian);

        Livewire::test(CommunicationForm::class)
            ->call('view', $communication->id)
            ->assertSet('isOpen', true)
            ->assertSet('editMode', false)
            ->assertSet('viewMode', true)
            ->assertSet('communication_id', $communication->id)
            ->assertSet('title', $communication->title)
            ->assertSet('message', $communication->message)
            ->assertSee($guardian->name)
            ->assertSee($guardian->email);
    }

    /**
     * Test that the component validates required fields
     */
    public function test_validates_required_fields(): void
    {
        Livewire::test(CommunicationForm::class)
            ->set('title', '')
            ->set('message', '')
            ->set('status', '')
            ->call('store')
            ->assertHasErrors([
                'title' => 'required',
                'message' => 'required',
                'status' => 'required'
            ]);
    }

    /**
     * Test that the component can close the modal
     */
    public function test_can_close_modal(): void
    {
        Livewire::test(CommunicationForm::class)
            ->set('isOpen', true)
            ->call('closeModal')
            ->assertSet('isOpen', false)
            ->assertDispatched('refreshParent')
            ->assertDispatched('refreshList');
    }

    /**
     * Test that the component resets form on close
     */
    public function test_resets_form_on_close(): void
    {
        $communication = Communication::factory()->create();
        
        Livewire::test(CommunicationForm::class)
            ->call('edit', $communication->id)
            ->call('closeModal')
            ->assertSet('communication_id', null)
            ->assertSet('title', '')
            ->assertSet('message', '')
            ->assertSet('course_id', null);
    }
} 