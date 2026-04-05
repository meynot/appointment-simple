<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Notes that resemble real scheduling and follow-up activity.
     *
     * @var array<int, string>
     */
    protected array $appointmentNotes = [
        'Initial consultation scheduled after phone intake review.',
        'Bring previous documents and confirm arrival 15 minutes early.',
        'Follow-up visit to review completed action items and next steps.',
        'Requested a shorter appointment window due to work schedule.',
        'Staff should call if any opening becomes available earlier in the day.',
        'Case requires confirmation with the client on the same morning.',
    ];

    protected static int $sequence = 1000;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'completed']);

        return [
            'sequence_number' => static::$sequence++,
            'client_id' => Client::factory(),
            'created_by' => User::factory()->staff(),
            'appointment_date' => $status === 'completed'
                ? fake()->dateTimeBetween('-2 months', '-1 day')
                : fake()->dateTimeBetween('+1 day', '+6 weeks'),
            'notes' => fake()->optional(0.85)->randomElement($this->appointmentNotes),
            'status' => $status,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'appointment_date' => fake()->dateTimeBetween('+1 day', '+6 weeks'),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'appointment_date' => fake()->dateTimeBetween('-2 months', '-1 day'),
        ]);
    }
}
