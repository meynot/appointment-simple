<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_clients_index(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('clients.index'));

        $response
            ->assertOk()
            ->assertSee($client->name);
    }

    public function test_authenticated_user_can_create_a_client(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('clients.store'), [
                'name' => 'Acme Client',
                'phone' => '555-0101',
                'address' => '123 Main Street',
                'notes' => 'First consultation pending.',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('clients.index'));

        $this->assertDatabaseHas('clients', [
            'name' => 'Acme Client',
            'phone' => '555-0101',
        ]);
    }

    public function test_authenticated_user_can_update_a_client(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put(route('clients.update', $client), [
                'name' => 'Updated Client',
                'phone' => '555-0102',
                'address' => '456 Oak Avenue',
                'notes' => 'Updated notes.',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('clients.index'));

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Updated Client',
            'phone' => '555-0102',
        ]);
    }

    public function test_authenticated_user_can_delete_a_client(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('clients.destroy', $client));

        $response->assertRedirect(route('clients.index'));

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
    }

    public function test_authenticated_user_can_filter_clients_by_search_and_appointment_state(): void
    {
        $user = User::factory()->create();
        $clientWithAppointment = Client::factory()->create([
            'name' => 'Apex Client',
        ]);
        $clientWithoutAppointment = Client::factory()->create([
            'name' => 'Beacon Client',
        ]);

        Appointment::factory()->create([
            'client_id' => $clientWithAppointment->id,
            'created_by' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('clients.index', [
                'search' => 'Apex',
                'appointments' => 'with',
            ]));

        $response
            ->assertOk()
            ->assertSee('Apex Client')
            ->assertDontSee('Beacon Client');
    }
}