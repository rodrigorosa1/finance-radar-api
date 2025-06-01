<?php

namespace Tests\Unit;

use App\DTOs\NotificationInDTO;
use App\DTOs\NotificationOutDTO;
use App\Enums\EnumStatusNotification;
use App\Repositories\Eloquent\NotificationRepository;
use App\Services\NotificationService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class NotificationServiceTest extends TestCase
{
    private $notificationRepository;

    protected function setUp(): void
    {
        $this->notificationRepository = $this->createMock(NotificationRepository::class);
    }

    public function test_should_save_notification_success(): void
    {
        $payload = new NotificationInDTO(
            '20eb83dc-c87d-4e96-866e-6dcfb74ed066',
            Carbon::now(),
            'SMTP.CHANNEL',
            'Bitcoin asset price is 10000'
        );

        $mockReturn = [
            'id' => 'ad292408-a20d-48ed-b0f6-2dd1f79bc67c',
            'alert_id' => '20eb83dc-c87d-4e96-866e-6dcfb74ed066',
            'sent_at' => Carbon::now(),
            'channel' => 'SMTP.CHANNEL',
            'message' => 'Bitcoin asset price is 10000',
            'status' =>  EnumStatusNotification::SENDER
        ];

        $expected = new NotificationOutDTO(
            'ad292408-a20d-48ed-b0f6-2dd1f79bc67c',
            '20eb83dc-c87d-4e96-866e-6dcfb74ed066',
            Carbon::now(),
            'SMTP.CHANNEL',
            'Bitcoin asset price is 10000'
        );

         $this->notificationRepository->method('create')->willReturn($mockReturn);
          $alertService = new NotificationService(
            $this->notificationRepository
        );

        $response = $alertService->create($payload);

        $this->assertEquals($expected, $response);

        $this->assertObjectHasProperty('id', $response);
        $this->assertObjectHasProperty('alertid', $response);
        $this->assertObjectHasProperty('sentAt', $response);
        $this->assertObjectHasProperty('channel', $response);
        $this->assertObjectHasProperty('message', $response);

        $this->assertEquals($expected->id, $response->id);
        $this->assertEquals($expected->alertid, $response->alertid);
        $this->assertEquals($expected->sentAt, $response->sentAt);
        $this->assertEquals($expected->channel, $response->channel);
        $this->assertEquals($expected->message, $response->message);
    }
}
