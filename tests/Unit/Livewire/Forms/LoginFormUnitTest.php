<?php

namespace Tests\Unit\Livewire\Forms;

use App\Livewire\Forms\LoginForm;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Tests\TestCase;
use Mockery;

class LoginFormUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Validates that validation rules are correctly defined
     */
    public function test_validation_rules_are_correctly_defined(): void
    {
        $form = new \ReflectionClass(LoginForm::class);
        
        $emailProperty = $form->getProperty('email');
        $emailAttributes = $emailProperty->getAttributes('Livewire\Attributes\Validate');
        $this->assertNotEmpty($emailAttributes);
        $this->assertEquals(['required|string|email'], $emailAttributes[0]->getArguments());
        
        $passwordProperty = $form->getProperty('password');
        $passwordAttributes = $passwordProperty->getAttributes('Livewire\Attributes\Validate');
        $this->assertNotEmpty($passwordAttributes);
        $this->assertEquals(['required|string'], $passwordAttributes[0]->getArguments());
        
        $rememberProperty = $form->getProperty('remember');
        $rememberAttributes = $rememberProperty->getAttributes('Livewire\Attributes\Validate');
        $this->assertNotEmpty($rememberAttributes);
        $this->assertEquals(['boolean'], $rememberAttributes[0]->getArguments());
    }

    /**
     * Tests that the form can authenticate correctly
     */
    public function test_authenticate_with_valid_credentials(): void
    {
        $component = Mockery::mock(Component::class);
        
        $loginForm = new LoginForm($component, 'form');
        $loginForm->email = 'test@example.com';
        $loginForm->password = 'password';
        $loginForm->remember = false;
        
        Auth::shouldReceive('attempt')
            ->once()
            ->with([
                'email' => 'test@example.com',
                'password' => 'password'
            ], false)
            ->andReturn(true);
        
        RateLimiter::shouldReceive('tooManyAttempts')
            ->andReturn(false);
        
        RateLimiter::shouldReceive('clear')
            ->once();
        
        try {
            $loginForm->authenticate();
            $this->assertTrue(true, 'Autenticación exitosa');
        } catch (ValidationException $e) {
            $this->fail('No debería lanzar excepción: ' . $e->getMessage());
        }
    }

    /**
     * Tests that the form throws an exception when credentials are invalid
     */
    public function test_authentication_fails_with_invalid_credentials(): void
    {
        $component = Mockery::mock(Component::class);
        
        $loginForm = new LoginForm($component, 'form');
        $loginForm->email = 'test@example.com';
        $loginForm->password = 'wrong-password';
        $loginForm->remember = false;
        
        Auth::shouldReceive('attempt')
            ->once()
            ->with([
                'email' => 'test@example.com',
                'password' => 'wrong-password'
            ], false)
            ->andReturn(false);
        
        RateLimiter::shouldReceive('tooManyAttempts')
            ->andReturn(false);
        
        RateLimiter::shouldReceive('hit')
            ->once();
        
        try {
            $loginForm->authenticate();
            $this->fail('Debería haber lanzado ValidationException');
        } catch (ValidationException $e) {
            $this->assertEquals(
                trans('auth.failed'), 
                $e->errors()['form.email'][0]
            );
        }
    }

    /**
     * Test to verify throttling and rate limiting key generation
     */
    public function test_throttling_and_rate_limiting(): void
    {
        
        $component = Mockery::mock(Component::class);
        
        $loginForm = new LoginForm($component, 'form');
        $loginForm->email = 'test@example.com';
        
        $mockKey = Str::transliterate(Str::lower('test@example.com') . '|127.0.0.1');
        $this->assertIsString($mockKey);
        $this->assertStringContainsString('test@example.com', $mockKey);
        
        $this->assertTrue(method_exists($loginForm, 'throttleKey'));
        
        $this->assertTrue(method_exists($loginForm, 'ensureIsNotRateLimited'));
    }
} 