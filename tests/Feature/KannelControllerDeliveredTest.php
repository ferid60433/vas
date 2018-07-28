<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Log\Logger;
use Symfony\Component\VarDumper\VarDumper;
use Tests\TestCase;
use Vas\SentMessage;

class KannelControllerDeliveredTest extends TestCase
{
    use DatabaseTransactions;

    public function statuses()
    {
        return [
            [0],
            [1],
            [2],
        ];
    }

    /**
     * @dataProvider statuses
     * @param $status
     */
    public function testKannelDelivery($status)
    {
        $sentMessage = factory(SentMessage::class)->create();
        $id = $sentMessage->id;

        $response = $this->get(route('kannel.delivered',
            compact('id', 'status')));

        app(Logger::class)->debug('Log Me', [$response]);

        $response->assertOk();
        $this->assertDatabaseHas('sent_messages', [
            'message' => $sentMessage->message,
            'address' => "{$sentMessage->address}",
            'delivery_status' => $status,
        ]);
    }
}
