<?php

namespace Tests\Feature\Livewire\Admin\Communications;

use App\Livewire\Admin\Communications\ManageCommunicationsComponent;
use App\Models\Communication;
use App\Models\Guardian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ManageCommunicationsComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the component can render
     */
    public function test_component_can_render(): void
    {
        $component = Livewire::test(ManageCommunicationsComponent::class);

        $component->assertStatus(200)
            ->assertViewIs('livewire.admin.communications.manage-communications-component');
    }

    /**
     * Test that the component can dispatch a create event
     */
    public function test_can_dispatch_create_event(): void
    {
        Livewire::test(ManageCommunicationsComponent::class)
            ->call('create')
            ->assertDispatched('create');
    }

    /**
     * Test that the component can dispatch an edit event
     */
    public function test_can_dispatch_edit_event(): void
    {
        $communication = Communication::factory()->create();

        Livewire::test(ManageCommunicationsComponent::class)
            ->call('edit', $communication->id)
            ->assertDispatched('edit', $communication->id);
    }

    /**
     * Test that the component can dispatch a view event
     */
    public function test_can_dispatch_view_event(): void
    {
        $communication = Communication::factory()->create();

        Livewire::test(ManageCommunicationsComponent::class)
            ->call('view', $communication->id)
            ->assertDispatched('view', $communication->id);
    }

    /**
     * Test that the component can delete a communication
     */
    public function test_can_delete_communication(): void
    {
        $communication = Communication::factory()->create();
        $guardian = Guardian::factory()->create();
        $communication->guardians()->attach($guardian);

        Livewire::test(ManageCommunicationsComponent::class)
            ->call('delete', $communication->id);

        $this->assertDatabaseMissing('communications', [
            'id' => $communication->id
        ]);

        $this->assertDatabaseMissing('communication_guardian', [
            'communication_id' => $communication->id,
            'guardian_id' => $guardian->id
        ]);
    }

    /**
     * Test that the component handles success messages
     */
    public function test_handles_success_message(): void
    {
        $component = Livewire::test(ManageCommunicationsComponent::class);

        $component->call('handleMessage', [
            'type' => 'success',
            'message' => 'Test success message'
        ]);

        $component->assertSet('successMessage', 'Test success message')
            ->assertSet('errorMessage', null);
    }

    /**
     * Test that the component handles error messages
     */
    public function test_handles_error_message(): void
    {
        $component = Livewire::test(ManageCommunicationsComponent::class);

        $component->call('handleMessage', [
            'type' => 'error',
            'message' => 'Test error message'
        ]);

        $component->assertSet('errorMessage', 'Test error message')
            ->assertSet('successMessage', null);
    }

    /**
     * Test that the component refreshes on refresh parent event
     */
    public function test_refreshes_on_refresh_parent_event(): void
    {
        $component = Livewire::test(ManageCommunicationsComponent::class);
        
        $component->call('$refresh')
            ->assertStatus(200);
    }
} 