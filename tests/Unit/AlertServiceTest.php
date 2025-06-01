<?php

namespace Tests\Unit;

use App\DTOs\AlertInDTO;
use App\DTOs\AlertOutDTO;
use App\Repositories\Eloquent\AlertRepository;
use App\Services\AlertService;
use DomainException;
use PHPUnit\Framework\TestCase;

class AlertServiceTest extends TestCase
{
    private $alertRepository;

    protected function setUp(): void
    {
        $this->alertRepository = $this->createMock(AlertRepository::class);
    }

    public function test_should_save_alert_success(): void
    {
        $payload = new AlertInDTO(
            '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'BTC',
            '>',
            190000.05,
            'USD',
            true
        );

        $mockReturn = [
            'id' => '20eb83dc-c87d-4e96-866e-6dcfb74ed066',
            'userId' => '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'symbol' => 'BTC',
            'condition' => '>',
            'value' =>  190000.05,
            'currency' => 'USD',
            'isActive' =>  true
        ];

        $expected = new AlertOutDTO(
            '20eb83dc-c87d-4e96-866e-6dcfb74ed066',
            '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'BTC',
            '>',
            190000.05,
            'USD',
            true
        );

        $this->alertRepository->method('create')->willReturn($mockReturn);
        $alertService = new AlertService(
            $this->alertRepository
        );

        $response = $alertService->create($payload);

        $this->assertEquals($expected, $response);
        $this->assertObjectHasProperty('id', $response);
        $this->assertObjectHasProperty('userId', $response);
        $this->assertObjectHasProperty('symbol', $response);
        $this->assertObjectHasProperty('condition', $response);
        $this->assertObjectHasProperty('value', $response);
        $this->assertObjectHasProperty('currency', $response);
        $this->assertObjectHasProperty('isActive', $response);
        $this->assertEquals($expected->id, $response->id);
        $this->assertEquals($expected->userId, $response->userId);
        $this->assertEquals($expected->symbol, $response->symbol);
        $this->assertEquals($expected->condition, $response->condition);
        $this->assertEquals($expected->value, $response->value);
        $this->assertEquals($expected->currency, $response->currency);
        $this->assertEquals($expected->isActive, $response->isActive);
    }

    public function test_should_return_success_in_update(): void
    {
        $payload = new AlertInDTO(
            '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'BTC',
            '>',
            190010.05,
            'USD',
            true
        );

        $mockReturn = [
            'id' => '20eb83dc-c87d-4e96-866e-6dcfb74ed066',
            'userId' => '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'symbol' => 'BTC',
            'condition' => '>',
            'value' =>  190000.05,
            'currency' => 'USD',
            'isActive' =>  true
        ];

        $this->alertRepository->method('findById')->willReturn($mockReturn);
        $this->alertRepository->method('update')->willReturn(true);

        $alertService = new AlertService(
            $this->alertRepository
        );

        $response = $alertService->update('20eb83dc-c87d-4e96-866e-6dcfb74ed066', $payload);

        $this->assertTrue(true);
        $this->assertEquals(true, $response);
    }

    public function test_should_return_user_error_not_located_in_update(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Alert not found');
        $this->expectExceptionCode(404);

        $payload = new AlertInDTO(
            '1466ad83-ca6c-4cf9-8b32-af61c2254fd2',
            'BTC',
            '>',
            190010.05,
            'USD',
            true
        );

        $this->alertRepository->method('findById')->willReturn([]);

        $alertService = new AlertService(
            $this->alertRepository
        );

        $alertService->update('20eb83dc-c87d-4e96-866e-6dcfb74ed066', $payload);
    }
}
