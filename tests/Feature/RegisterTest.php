<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;

class RegisterTest extends TestCase
{
    /* This destroys and recreates database before testing - caution! */
    use RefreshDatabase;  // Destroys and recreates DB for testing

    /** @test */
    function logon()
    {
        $user = factory(User::class)->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => bcrypt('123456')
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
}