<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_users_index(): void
    {
        $user = User::factory()->admin()->create();
        $listedUser = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('users.index'));

        $response
            ->assertOk()
            ->assertSee($listedUser->name);
    }

    public function test_admin_can_create_a_user(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('users.store'), [
                'name' => 'New User',
                'email' => 'new-user@example.com',
                'role' => 'admin',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'new-user@example.com',
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_update_a_user_without_changing_password(): void
    {
        $user = User::factory()->admin()->create();
        $managedUser = User::factory()->create([
            'email' => 'managed@example.com',
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('users.update', $managedUser), [
                'name' => 'Updated Name',
                'email' => 'managed@example.com',
                'role' => 'user',
                'password' => '',
                'password_confirmation' => '',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $managedUser->id,
            'name' => 'Updated Name',
            'email' => 'managed@example.com',
        ]);
    }

    public function test_admin_cannot_delete_themselves_from_users_crud(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('users.destroy', $user));

        $response
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    public function test_staff_user_cannot_view_users_index(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('users.index'));

        $response->assertForbidden();
    }

    public function test_staff_user_cannot_create_a_user(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('users.store'), [
                'name' => 'Blocked User',
                'email' => 'blocked@example.com',
                'role' => 'user',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('users', [
            'email' => 'blocked@example.com',
        ]);
    }

    public function test_admin_can_filter_users_by_search_and_role(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Alice Admin',
            'email' => 'alice@example.com',
        ]);

        User::factory()->create([
            'name' => 'Sam Staff',
            'email' => 'sam@example.com',
            'role' => 'user',
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('users.index', [
                'search' => 'Alice',
                'role' => 'admin',
            ]));

        $response
            ->assertOk()
            ->assertSee('Alice Admin')
            ->assertDontSee('Sam Staff');
    }
}