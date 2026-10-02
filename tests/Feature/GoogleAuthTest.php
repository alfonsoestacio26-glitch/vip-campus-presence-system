<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_redirect_route_redirects_to_google(): void
    {
        config([
            'services.google.client_id' => 'dummy-client-id',
            'services.google.client_secret' => 'dummy-client-secret',
        ]);

        $response = $this->get(route('auth.google'));

        $response->assertStatus(302);
        $this->assertStringContainsString('accounts.google.com', $response->getTargetUrl());
    }

    public function test_existing_user_can_authenticate_via_google(): void
    {
        $user = User::factory()->create([
            'email' => 'teacher.test@vip.edu.ph',
            'role' => 'teacher',
        ]);

        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')->andReturn('google-id-12345');
        $abstractUser->shouldReceive('getEmail')->andReturn('teacher.test@vip.edu.ph');
        $abstractUser->shouldReceive('getName')->andReturn('Teacher Test');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/avatar.jpg');

        $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);

        $user->refresh();
        $this->assertEquals('google-id-12345', $user->google_id);
        $this->assertEquals('https://lh3.googleusercontent.com/avatar.jpg', $user->google_avatar);
    }

    public function test_new_user_is_created_on_google_login_with_default_parent_role(): void
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')->andReturn('google-id-99999');
        $abstractUser->shouldReceive('getEmail')->andReturn('newparent@gmail.com');
        $abstractUser->shouldReceive('getName')->andReturn('New Parent');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/avatar2.jpg');

        $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'newparent@gmail.com',
            'role' => 'parent',
            'google_id' => 'google-id-99999',
        ]);

        $newUser = User::where('email', 'newparent@gmail.com')->first();
        $this->assertAuthenticatedAs($newUser);
    }

    public function test_google_login_handles_cancellation_or_errors_gracefully(): void
    {
        $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andThrow(new \Exception('OAuth Access Denied'));

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Google Sign-In failed or was cancelled. Please try again.');
        $this->assertGuest();
    }
}
