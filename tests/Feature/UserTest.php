<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_check_if_user_is_an_admin()
    {
        $user = User::factory()->make([
            'email' => 'khoirony@gmail.com',
        ]);

        $userB = User::factory()->make([
            'email' => 'test@gmail.com',
        ]);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($userB->isAdmin());
    }
}
