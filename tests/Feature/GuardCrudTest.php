<?php

namespace Tests\Feature;

use App\Models\Guard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuardCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user to perform actions
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_guards_index_page_can_be_rendered(): void
    {
        $response = $this
            ->actingAs($this->admin)
            ->get(route('guards.index'));

        $response->assertOk();
    }

    public function test_guard_can_be_created_with_associated_user(): void
    {
        $response = $this
            ->actingAs($this->admin)
            ->post(route('guards.store'), [
                'employee_no' => 'GRD-001',
                'first_name' => 'Bob',
                'last_name' => 'Guard',
                'contact_number' => '09123456789',
                'email' => 'bob.guard@school.com',
                'password' => 'secret123',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('guards.index'));

        // Assert user was created
        $this->assertDatabaseHas('users', [
            'email' => 'bob.guard@school.com',
            'role' => 'guard',
        ]);

        // Assert guard was created
        $this->assertDatabaseHas('guards', [
            'employee_no' => 'GRD-001',
            'first_name' => 'Bob',
            'last_name' => 'Guard',
            'contact_number' => '09123456789',
        ]);
    }

    public function test_guard_can_be_updated(): void
    {
        // Pre-create guard user & profile
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old.guard@school.com',
            'role' => 'guard',
        ]);
        $guard = Guard::create([
            'user_id' => $user->id,
            'employee_no' => 'GRD-OLD',
            'first_name' => 'Old',
            'last_name' => 'Name',
        ]);

        $response = $this
            ->actingAs($this->admin)
            ->put(route('guards.update', $guard), [
                'employee_no' => 'GRD-NEW',
                'first_name' => 'New',
                'last_name' => 'Name',
                'contact_number' => '09998887777',
                'email' => 'new.guard@school.com',
                'password' => 'newpassword123',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('guards.index'));

        $this->assertDatabaseHas('guards', [
            'id' => $guard->id,
            'employee_no' => 'GRD-NEW',
            'first_name' => 'New',
            'last_name' => 'Name',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'new.guard@school.com',
        ]);
    }

    public function test_guard_can_be_deleted_along_with_associated_user(): void
    {
        $user = User::factory()->create([
            'role' => 'guard',
        ]);
        $guard = Guard::create([
            'user_id' => $user->id,
            'employee_no' => 'GRD-DEL',
            'first_name' => 'Delete',
            'last_name' => 'Me',
        ]);

        $response = $this
            ->actingAs($this->admin)
            ->delete(route('guards.destroy', $guard));

        $response->assertRedirect(route('guards.index'));

        $this->assertDatabaseMissing('guards', [
            'id' => $guard->id,
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
