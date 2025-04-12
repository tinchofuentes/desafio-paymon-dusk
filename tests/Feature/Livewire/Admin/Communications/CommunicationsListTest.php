<?php

namespace Tests\Feature\Livewire\Admin\Communications;

use App\Enums\CommunicationStatus;
use App\Livewire\Admin\Communications\CommunicationsList;
use App\Models\Communication;
use App\Models\Course;
use App\Models\Guardian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CommunicationsListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the component can render
     */
    public function test_component_can_render(): void
    {
        Livewire::test(CommunicationsList::class)
            ->assertOk();
    }

    /**
     * Test that the component can list communications
     */
    public function test_can_list_communications(): void
    {
        $communications = Communication::factory()->count(3)->create();

        $component = Livewire::test(CommunicationsList::class);
        
        foreach ($communications as $communication) {
            $component->assertSee($communication->title);
        }
    }

    /**
     * Test that the component can filter communications by search
     */
    public function test_can_filter_communications_by_search(): void
    {
        $matchingCommunication = Communication::factory()->create([
            'title' => 'Test Communication'
        ]);
        
        $nonMatchingCommunication = Communication::factory()->create([
            'title' => 'Other Communication'
        ]);

        Livewire::test(CommunicationsList::class)
            ->set('search', 'Test')
            ->assertSee($matchingCommunication->title)
            ->assertDontSee($nonMatchingCommunication->title);

        // Test message search
        $messageMatchingCommunication = Communication::factory()->create([
            'message' => 'Test Message Content'
        ]);

        Livewire::test(CommunicationsList::class)
            ->set('search', 'Message Content')
            ->assertSee($messageMatchingCommunication->title);
    }

    /**
     * Test that the component can filter communications by status
     */
    public function test_can_filter_communications_by_status(): void
    {
        $draftCommunication = Communication::factory()->create([
            'status' => CommunicationStatus::DRAFT
        ]);
        
        $sentCommunication = Communication::factory()->create([
            'status' => CommunicationStatus::SENT
        ]);

        Livewire::test(CommunicationsList::class)
            ->set('statusFilter', CommunicationStatus::DRAFT->value)
            ->assertSee($draftCommunication->title)
            ->assertDontSee($sentCommunication->title);

        // Test no filter
        $component = Livewire::test(CommunicationsList::class)
            ->set('statusFilter', '');

        $component->assertSee($draftCommunication->title)
                 ->assertSee($sentCommunication->title);
    }

    /**
     * Test that the component can filter communications by date
     */
    public function test_can_filter_communications_by_date(): void
    {
        $todayCommunication = Communication::factory()->create([
            'send_date' => now()
        ]);
        
        $oldCommunication = Communication::factory()->create([
            'send_date' => now()->subDays(5)
        ]);

        // Test today's communications
        Livewire::test(CommunicationsList::class)
            ->set('dateFilter', now()->format('Y-m-d'))
            ->assertSee($todayCommunication->title)
            ->assertDontSee($oldCommunication->title);

        // Test no date filter
        $component = Livewire::test(CommunicationsList::class)
            ->set('dateFilter', '');

        $component->assertSee($todayCommunication->title)
                 ->assertSee($oldCommunication->title);
    }

    /**
     * Test that the component can delete a communication
     */
    public function test_can_delete_communication(): void
    {
        $communication = Communication::factory()->create();
        $guardian = Guardian::factory()->create();
        $communication->guardians()->attach($guardian);

        Livewire::test(CommunicationsList::class)
            ->call('delete', $communication->id)
            ->assertDispatched('showMessage');

        $this->assertDatabaseMissing('communications', [
            'id' => $communication->id
        ]);

        $this->assertDatabaseMissing('communication_guardian', [
            'communication_id' => $communication->id,
            'guardian_id' => $guardian->id
        ]);
    }

    /**
     * Test that the component can dispatch an edit event
     */
    public function test_can_dispatch_edit_event(): void
    {
        $communication = Communication::factory()->create();

        Livewire::test(CommunicationsList::class)
            ->call('edit', $communication->id)
            ->assertDispatched('edit', $communication->id);
    }

    /**
     * Test that the component can dispatch a view event
     */
    public function test_can_dispatch_view_event(): void
    {
        $communication = Communication::factory()->create();

        Livewire::test(CommunicationsList::class)
            ->call('view', $communication->id)
            ->assertDispatched('view', $communication->id);
    }

    /**
     * Test that the component refreshes on refresh list event
     */
    public function test_refreshes_on_refresh_list_event(): void
    {
        $component = Livewire::test(CommunicationsList::class);
        
        $component->call('$refresh')
            ->assertStatus(200);
    }

    /**
     * Test that the component can paginate communications
     */
    public function test_pagination_works(): void
    {
        Communication::factory()->count(15)->create();

        Livewire::test(CommunicationsList::class)
            ->assertViewHas('communications');
    }
} 