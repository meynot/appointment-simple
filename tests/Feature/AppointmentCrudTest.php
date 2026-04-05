<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_appointments_index(): void
    {
        $user = User::factory()->create();
        $appointment = Appointment::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('appointments.index'));

        $response
            ->assertOk()
            ->assertSee((string) $appointment->sequence_number)
            ->assertSee($appointment->client->name);
    }

    public function test_authenticated_user_can_create_an_appointment(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('appointments.store'), [
                'client_id' => $client->id,
                'appointment_date' => '2026-05-10 14:30:00',
                'status' => 'pending',
                'notes' => 'Initial appointment.',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('appointments.index'));

        $this->assertDatabaseHas('appointments', [
            'client_id' => $client->id,
            'created_by' => $user->id,
            'sequence_number' => 1,
            'status' => 'pending',
        ]);
    }

    public function test_authenticated_user_can_update_an_appointment(): void
    {
        $user = User::factory()->create();
        $appointment = Appointment::factory()->create();
        $client = Client::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put(route('appointments.update', $appointment), [
                'client_id' => $client->id,
                'appointment_date' => '2026-06-01 09:00:00',
                'status' => 'completed',
                'notes' => 'Completed appointment.',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('appointments.index'));

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'client_id' => $client->id,
            'status' => 'completed',
        ]);
    }

    public function test_authenticated_user_can_delete_an_appointment(): void
    {
        $user = User::factory()->create();
        $appointment = Appointment::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('appointments.destroy', $appointment));

        $response->assertRedirect(route('appointments.index'));

        $this->assertDatabaseMissing('appointments', [
            'id' => $appointment->id,
        ]);
    }

    public function test_client_detail_page_shows_linked_appointments(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'name' => 'Linked Client',
        ]);
        $appointment = Appointment::factory()->create([
            'client_id' => $client->id,
            'created_by' => $user->id,
            'sequence_number' => 44,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('clients.show', $client));

        $response
            ->assertOk()
            ->assertSee('Appointments')
            ->assertSee('44')
            ->assertSee($appointment->creator->name);
    }

    public function test_authenticated_user_can_filter_appointments_by_search_and_status(): void
    {
        $user = User::factory()->create([
            'name' => 'Scheduler',
        ]);
        $client = Client::factory()->create([
            'name' => 'Target Client',
        ]);

        Appointment::factory()->create([
            'sequence_number' => 300,
            'client_id' => $client->id,
            'created_by' => $user->id,
            'status' => 'pending',
            'notes' => 'Target note',
        ]);

        Appointment::factory()->create([
            'sequence_number' => 301,
            'status' => 'completed',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('appointments.index', [
                'search' => 'Target',
                'status' => 'pending',
                'client_id' => $client->id,
            ]));

        $response
            ->assertOk()
            ->assertSee('300')
            ->assertSee('Target Client')
            ->assertDontSee('301');
    }
}