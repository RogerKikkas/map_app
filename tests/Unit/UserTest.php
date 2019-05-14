<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    /*
    public function test_user_can_register()
    {
        $data = [
            'email' => 'test@test.com',
            'name' => 'test',
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ];

        $this->post('/api/auth/register', $data)->assertStatus(200);
    }
    */

    public function test_user_can_login()
    {
        $data = [
            'email' => 'user@example.com',
            'password' => 'secret'
        ];

        $this->post('/api/auth/login', $data)->assertStatus(200);
    }

    public function test_logged_in_user_can_get_data()
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get('/api/usersForMap')
            ->assertStatus(200);
    }
}