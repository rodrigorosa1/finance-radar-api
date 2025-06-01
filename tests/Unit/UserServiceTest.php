<?php

namespace Tests\Unit;

use App\DTOs\UserInDTO;
use App\DTOs\UserOutDTO;
use App\Enums\EnumTypeNotification;
use App\Repositories\Eloquent\UserRepository;
use App\Services\UserService;
use DomainException;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
    }

    public function test_should_save_user_register(): void
    {
        $payload = new UserInDTO(
            'Anakin Skywalker',
            'anakin.skywalker@jedi.com',
            'pass',
            '+5551984863711',
            EnumTypeNotification::EMAIL
        );

        $mockReturn = [
            'id' => '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'name' => 'Anakin Skywalker',
            'email' => 'anakin.skywalker@jedi.com',
            'phone' => '+5551984863711',
            'type_notification' =>  EnumTypeNotification::EMAIL
        ];

        $expected = new UserOutDTO(
            '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'Anakin Skywalker',
            'anakin.skywalker@jedi.com',
            '+5551984863711',
            EnumTypeNotification::EMAIL
        );

        $this->userRepository->method('validEmailExists')->willReturn(false);
        $this->userRepository->method('create')->willReturn($mockReturn);
        $userService = new UserService(
            $this->userRepository
        );

        $response = $userService->register($payload);

        $this->assertTrue(true);

        $this->assertEquals($expected, $response);
        $this->assertObjectHasProperty('id', $response);
        $this->assertObjectHasProperty('name', $response);
        $this->assertObjectHasProperty('email', $response);
        $this->assertObjectHasProperty('phone', $response);
        $this->assertObjectHasProperty('typeNotification', $response);
        $this->assertEquals($expected->id, $response->id);
        $this->assertEquals($expected->name, $response->name);
        $this->assertEquals($expected->email, $response->email);
        $this->assertEquals($expected->phone, $response->phone);
        $this->assertEquals($expected->typeNotification, $response->typeNotification);
    }

    public function test_should_faill_register_email_exists(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Email already registered');
        $this->expectExceptionCode(405);

        $payload = new UserInDTO(
            'Anakin Skywalker',
            'anakin.skywalker@jedi.com',
            'pass',
            '+5551984863711',
            EnumTypeNotification::EMAIL
        );

        $this->userRepository->method('validEmailExists')->willReturn(true);
        $userService = new UserService(
            $this->userRepository
        );

        $userService->register($payload);
    }

    public function test_should_return_user(): void
    {
        $expected = new UserOutDTO(
            '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'Anakin Skywalker',
            'anakin.skywalker@jedi.com',
            '+5551984863711',
            EnumTypeNotification::EMAIL
        );

        $mockReturn = [
            'id' => '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'name' => 'Anakin Skywalker',
            'email' => 'anakin.skywalker@jedi.com',
            'phone' => '+5551984863711',
            'type_notification' =>  EnumTypeNotification::EMAIL
        ];

        $payload = [
            'id' => '1466ad83-ca6c-4cf9-8b32-af61c2254fd2'
        ];

        $this->userRepository->method('findById')->willReturn($mockReturn);

        $userService = new UserService(
            $this->userRepository
        );
        $response = $userService->findById($payload['id']);

        $this->assertTrue(true);

        $this->assertEquals($expected, $response);
        $this->assertObjectHasProperty('id', $response);
        $this->assertObjectHasProperty('name', $response);
        $this->assertObjectHasProperty('email', $response);
        $this->assertObjectHasProperty('phone', $response);
        $this->assertObjectHasProperty('typeNotification', $response);
        $this->assertEquals($expected->id, $response->id);
        $this->assertEquals($expected->name, $response->name);
        $this->assertEquals($expected->email, $response->email);
        $this->assertEquals($expected->phone, $response->phone);
        $this->assertEquals($expected->typeNotification, $response->typeNotification);
    }

    public function test_should_return_exception_in_not_found_user(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('User not found');
        $this->expectExceptionCode(404);

        $payload = [
            'id' => '1466ad83-ca6c-4cf9-8b32-af61c2254fd2'
        ];

        $this->userRepository->method('findById')->willReturn([]);

        $userService = new UserService(
            $this->userRepository
        );

        $userService->findById($payload['id']);
    }

    public function test_should_return_success_update(): void
    {
        $payload = new UserInDTO(
            'Anakin Skywalker',
            'anakin.skywalker@jedi.com',
            'pass',
            '+5551984863711',
            EnumTypeNotification::WATTSAPP
        );

        $mockReturn = [
            'id' => '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'name' => 'Anakin Skywalker',
            'email' => 'anakin.skywalker@jedi.com',
            'phone' => '+5551984863711',
            'type_notification' =>  EnumTypeNotification::WATTSAPP
        ];

        $this->userRepository->method('findById')->willReturn($mockReturn);
         $this->userRepository->method('update')->willReturn(true);
        $userService = new UserService(
            $this->userRepository
        );

        $response = $userService->update('1466ad83-ca6c-4cf9-8b32-af61c2254fd2', $payload);

        $this->assertTrue(true);
        $this->assertEquals(true, $response);
    }

    public function test_should_return_exception_user_not_found_update(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('User not found');
        $this->expectExceptionCode(404);

        $payload = new UserInDTO(
            'Anakin Skywalker',
            'anakin.skywalker@jedi.com',
            'pass',
            '+5551984863711',
            EnumTypeNotification::WATTSAPP
        );

        $this->userRepository->method('findById')->willReturn([]);
         $userService = new UserService(
            $this->userRepository
        );

        $userService->update('1466ad83-ca6c-4cf9-8b32-af61c2254fd2', $payload);
    }
}
