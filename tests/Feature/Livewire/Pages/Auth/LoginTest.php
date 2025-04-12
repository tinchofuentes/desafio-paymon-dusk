<?php

namespace Tests\Feature\Livewire\Pages\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        RateLimiter::clear('auth');
    }

    /**
     * Test login page contains livewire component
     */
    public function test_login_page_contains_livewire_component()
    {
        $this->get(route('login'))
            ->assertStatus(200)
            ->assertSeeLivewire('pages.auth.login');
    }

    /**
     * Test users can authenticate with valid credentials
     */
    public function test_users_can_authenticate_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Livewire::test('pages.auth.login')
            ->set('form.email', 'test@example.com')
            ->set('form.password', 'password')
            ->set('form.remember', true)
            ->call('login');

        $this->assertAuthenticated();
    }

    /**
     * Test users cannot authenticate with invalid password
     */
    public function test_users_cannot_authenticate_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Livewire::test('pages.auth.login')
            ->set('form.email', 'test@example.com')
            ->set('form.password', 'wrong-password')
            ->call('login')
            ->assertHasErrors(['form.email']);
        
        $this->assertGuest();
    }

    /**
     * Test email is required
     */
    public function test_email_is_required()
    {
        Livewire::test('pages.auth.login')
            ->set('form.email', '')
            ->set('form.password', 'password')
            ->call('login')
            ->assertHasErrors(['form.email' => 'required']);
    }

    /**
     * Test email must be valid
     */
    public function test_email_must_be_valid_email()
    {
        Livewire::test('pages.auth.login')
            ->set('form.email', 'not-an-email')
            ->set('form.password', 'password')
            ->call('login')
            ->assertHasErrors(['form.email' => 'email']);
    }

    /**
     * Test password is required
     */
    public function test_password_is_required()
    {
        Livewire::test('pages.auth.login')
            ->set('form.email', 'test@example.com')
            ->set('form.password', '')
            ->call('login')
            ->assertHasErrors(['form.password' => 'required']);
    }
} 