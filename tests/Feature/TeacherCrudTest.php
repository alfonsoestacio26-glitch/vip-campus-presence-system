<?php

namespace Tests\Feature;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherCrudTest extends TestCase
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

    public function test_teachers_index_page_can_be_rendered(): void
    {
        $response = $this
            ->actingAs($this->admin)
            ->get(route('teachers.index'));

        $response->assertOk();
    }

    public function test_teacher_can_be_created_with_associated_user(): void
    {
        $response = $this
            ->actingAs($this->admin)
            ->post(route('teachers.store'), [
                'employee_no' => 'TCH-001',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'contact_number' => '09123456789',
                'email' => 'john.doe@school.com',
                'password' => 'secret123',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('teachers.index'));

        // Assert user was created
        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@school.com',
            'role' => 'teacher',
        ]);

        // Assert teacher was created
        $this->assertDatabaseHas('teachers', [
            'employee_no' => 'TCH-001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'contact_number' => '09123456789',
        ]);
    }

    public function test_teacher_can_be_updated(): void
    {
        // Pre-create teacher user & profile
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@school.com',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'employee_no' => 'TCH-OLD',
            'first_name' => 'Old',
            'last_name' => 'Name',
        ]);

        $response = $this
            ->actingAs($this->admin)
            ->put(route('teachers.update', $teacher), [
                'employee_no' => 'TCH-NEW',
                'first_name' => 'New',
                'last_name' => 'Name',
                'contact_number' => '09998887777',
                'email' => 'new@school.com',
                'password' => 'newpassword123',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('teachers.index'));

        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'employee_no' => 'TCH-NEW',
            'first_name' => 'New',
            'last_name' => 'Name',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'new@school.com',
        ]);
    }

    public function test_teacher_can_be_deleted_along_with_associated_user(): void
    {
        $user = User::factory()->create([
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'employee_no' => 'TCH-DEL',
            'first_name' => 'Delete',
            'last_name' => 'Me',
        ]);

        $response = $this
            ->actingAs($this->admin)
            ->delete(route('teachers.destroy', $teacher));

        $response->assertRedirect(route('teachers.index'));

        $this->assertDatabaseMissing('teachers', [
            'id' => $teacher->id,
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
