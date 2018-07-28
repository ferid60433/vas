<?php

namespace Tests\Feature\Kannel;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Vas\Service;

class ControllerReceivedTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    protected $address;

    public function textData()
    {
        return [
            ['', 'MESSAGE_EMPTY'],
            ['  ', 'MESSAGE_EMPTY'],
            ["\t \n", 'MESSAGE_EMPTY'],
            [null, 'MESSAGE_EMPTY'],

            ['H', 'MESSAGE_HELP'],
            [' h', 'MESSAGE_HELP'],
            ['Help', 'MESSAGE_HELP'],
            [' H ', 'MESSAGE_HELP'],
            [' help me please please please', 'MESSAGE_HELP'],

            [' s', 'MESSAGE_NOT_SUBSCRIBED_YET'],
            ['S ', 'MESSAGE_NOT_SUBSCRIBED_YET'],
            ['STOP', 'MESSAGE_NOT_SUBSCRIBED_YET'],
            [' sssstop lorem ipsum ', 'MESSAGE_NOT_SUBSCRIBED_YET'],

            [' 12345 ', 'MESSAGE_DEFAULT'],
            [' lorem ', 'MESSAGE_DEFAULT'],
            [" W\tT\tF?", 'MESSAGE_DEFAULT'],
        ];
    }

    public function testSubscriberStopMessage()
    {
        /** @var Service $service */
        $service = factory(Service::class)->create(['letter' => 'LET']);

        $this->testGenericMessage($service->letter, $service->confirmation_message);

        $this->assertDatabaseHas('subscribers', [
            'service_id' => $service->id,
            'address' => "{$this->address}",
            'deleted_at' => null,
        ]);

        $this->testGenericMessage('STOP', 'MESSAGE_STOP', "{$this->address}");

        $this->assertSoftDeleted('subscribers', [
            'service_id' => $service->id,
            'address' => "{$this->address}",
        ]);
    }

    /**
     * @param $message
     * @param $messageReply
     * @param null $oldAddress
     * @dataProvider textData
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function testGenericMessage($message, $messageReply, $oldAddress = null)
    {
        $reply = starts_with($messageReply, 'MESSAGE_') ?
            env($messageReply) : $messageReply;

        $this->address = $address = $oldAddress ??
            $this->faker->randomNumber(8, true);

        $response = $this->post('api/kannel/received', [
            'messageId' => $this->faker->uuid,
            'from' => "2519{$address}",
            'to' => $this->faker->boolean ? env('MT') : env('MO'),
            'content' => $message,
        ]);

        $response
            ->assertOk()
            ->assertSee($reply)
            ->assertHeader('X-Kannel-SMSC', 'mtSmsc')
            ->assertHeader('X-Kannel-From', env('MO'))
            ->assertHeader('X-Kannel-DLR-Mask', 3);

        $this->assertDatabaseHas('received_messages', [
            'message' => trim($message),
            'address' => "{$address}",
        ]);

        $this->assertDatabaseHas('sent_messages', [
            'message' => $reply ?? '',
            'address' => "{$address}",
            'delivery_status' => 0,
        ]);

        return $response;
    }

    public function testOwnerCommandMessage()
    {
        /** @var Service $service */
        factory(Service::class)->create(['letter' => 'CMD']);

        $this->testGenericMessage(
            '@CMD,Test',
            'MESSAGE_OWNER_COMMAND',
            env('OWNER_ADDRESS'));

        // TODO: dispatch send job
    }

    public function testUnicodeResponse()
    {
        putenv('MESSAGE_HELP="Yared Negu - Yagute | ያጉቴ - New Ethiopian Music 2017 (Official Video)"');
        $response = $this->testGenericMessage('Help', 'MESSAGE_HELP');
        $response->assertHeader('X-Kannel-Coding', '2');
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
    }
}
