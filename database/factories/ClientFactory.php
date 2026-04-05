<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Realistic cities and areas used to build addresses.
     *
     * @var array<int, string>
     */
    protected array $areas = [
        'Riyadh - Al Olaya',
        'Jeddah - Al Rawdah',
        'Dammam - Al Faisaliyah',
        'Khobar - Al Aqrabiyah',
        'Makkah - Al Aziziyah',
        'Madinah - Quba',
        'Abha - Al Shifa',
        'Taif - Al Hada',
    ];

    /**
     * Case-style notes used to make client records read more naturally.
     *
     * @var array<int, string>
     */
    protected array $clientNotes = [
        'Prefers afternoon appointments and confirms by phone.',
        'Asked to keep reminder calls one day before the appointment.',
        'Follow-up case with previous appointment history on file.',
        'Family contact usually answers first and relays schedule updates.',
        'Needs a clear printed summary after each completed visit.',
        'Requested faster check-in due to travel distance.',
    ];

    protected static int $phoneSequence = 50000000;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hasAddress = fake()->boolean(85);
        $hasNotes = fake()->boolean(75);

        return [
            'name' => fake()->name(),
            'phone' => '05' . static::$phoneSequence++,
            'address' => $hasAddress
                ? fake()->buildingNumber() . ' ' . fake()->streetName() . ', ' . fake()->randomElement($this->areas)
                : null,
            'notes' => $hasNotes ? fake()->randomElement($this->clientNotes) : null,
        ];
    }

    public function withNotes(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => fake()->randomElement($this->clientNotes),
        ]);
    }

    public function withoutNotes(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => null,
        ]);
    }
}
