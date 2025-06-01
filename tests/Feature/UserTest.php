<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_register_response(): void
    {
        $payload = [
            'name' => 'Anakin Skywalker',
            'email' => 'dev',
            'password' => 'test',
            'phone' => '5548999999',
            'typeNotification' => 1
        ];
        $response = $this->post('/api/v1/user/register', $payload);
        dd($response);

        $response->assertStatus(201);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertArrayHasKey('name', $response['data']);
        $this->assertArrayHasKey('email', $response['data']);
        $this->assertArrayHasKey('phone', $response['data']);
        $this->assertArrayHasKey('typeNotification', $response['data']);
        $this->assertEquals($payload['name'], $response['data']['name']);
        $this->assertEquals($payload['email'], $response['data']['email']);
        $this->assertEquals($payload['phone'], $response['data']['phone']);
        $this->assertEquals($payload['typeNotification'], $response['data']['typeNotification']);

        // User::find($response['data']['id'])->delete();
    }

    // public function test_user_update_response(): void
    // {
    //     $user = User::factory()->create();
    //     $payload = [
    //         'name' => $user->name,
    //         'email' => $user->email,
    //         'password' => $user->password,
    //         'phone' => $user->phone,
    //         'typeNotification' => $user->type_notification,
    //     ];

    //     $response = $this->post('/api/user/register', $payload);

    // }
}
