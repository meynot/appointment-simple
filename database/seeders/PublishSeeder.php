<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublishSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = collect()
            ->merge(User::factory()->count(10)->admin()->create())
            ->merge(User::factory()->count(90)->staff()->create());

        $clients = Client::factory()->count(100)->create();

        Appointment::factory()
            ->count(500)
            ->state(fn () => [
                'client_id' => $clients->random()->id,
                'created_by' => $users->random()->id,
            ])
            ->create();
    }
}