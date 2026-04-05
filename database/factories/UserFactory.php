<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Common names used to generate more realistic internal staff accounts.
     *
     * @var array<int, string>
     */
    protected array $staffNames = [
        'Ahmed Hassan',
        'Fatima Ali',
        'Mohammed Saeed',
        'Noura Khalid',
        'Omar Adel',
        'Sara Ibrahim',
        'Yousef Mahmoud',
        'Laila Mostafa',
        'Khaled Samir',
        'Mariam Tarek',
    ];

    /**
     * Common domains used for business-like email addresses.
     *
     * @var array<int, string>
     */
    protected array $emailDomains = [
        'appointments.local',
        'clinicdesk.test',
        'opsmail.test',
    ];

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    protected static int $emailSequence = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement($this->staffNames);
        $emailSlug = Str::of($name)->lower()->replace(' ', '.');

        return [
            'name' => $name,
            'email' => sprintf(
                '%s%d@%s',
                $emailSlug,
                static::$emailSequence++,
                fake()->randomElement($this->emailDomains),
            ),
            'email_verified_at' => now(),
            'role' => 'user',
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function staff(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'user',
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'email' => sprintf('admin%d@appointments.local', static::$emailSequence++),
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
