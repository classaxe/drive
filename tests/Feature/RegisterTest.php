<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Auth\Notifications\VerifyEmail;

class RegisterTest extends TestCase
{
    /* This destroys and recreates database before testing - caution! */
    use RefreshDatabase;  // Destroys and recreates DB for testing

    /** @test */
    function logon()
    {
        $user = factory(User::class)->create([
            'name' => 'Test created without post',
            'email' => 'test@example.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => null
        ]);
    
        $response = $this->post('login', [
            'email' => 'test@example.com',
            'password' => '123456'
        ]);

        // Confirm redirect occured
        $response->assertRedirect('/home');

        // Confirm user is logged in
        $this->assertTrue(Auth::check());
    }

    /** @test */
    function register_and_logon()
    {
        $response = $this->post('register', [
            'name' => 'Test2',
            'email' => 'test2@example.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        // Confirm redirct occurred
        $response->assertRedirect('/home');

        // Confirm user is logged in
        $this->assertTrue(Auth::check());
    }

    /** @test */
    public function verify_email_validates_user(): void
    {
        // VerifyEmail extends Illuminate\Auth\Notifications\VerifyEmail in this example
        $notification = new VerifyEmail();
        $user = factory(User::class)->create([ 'email_verified_at' => null ]);
    
        // New user should not has verified their email yet
        $this->assertFalse($user->hasVerifiedEmail());
    
        $mail = $notification->toMail($user);
        $uri = $mail->actionUrl;
    
        // Simulate clicking on the validation link
        $this->actingAs($user)
            ->get($uri);
    
        // User should have verified their email
        $this->assertTrue(User::find($user->id)->hasVerifiedEmail());
    }
}