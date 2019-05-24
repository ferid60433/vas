<?php

namespace Tests\Feature\Kannel;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Log\Logger;
use Symfony\Component\VarDumper\VarDumper;
use Tests\TestCase;
use Vas\SentMessage;

class ControllerDeliveredTest extends TestCase
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

        $response->assertOk();
        $this->assertDatabaseHas('sent_messages', [
            'message' => $sentMessage->message,
            'address' => "{$sentMessage->address}",
            'delivery_status' => $status,
        ]);
    }
}
