<?php

namespace Vas\Processors;

use GuzzleHttp\Client;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Input;
use Vas\ReceivedMessage;

class CentProcessor extends Processor
{
    /** @var Client */
    protected $client;

    /**
     * CentProcessor constructor.
     * @param Client $client
     * @param Logger $logger
     */
    public function __construct(Client $client, Logger $logger)
    {
        parent::__construct($logger);

        $this->client = $client;
    }

    public function isHandleable(ReceivedMessage $message): bool
    {
        $msg = $this->trimThenUpper($message->message);

        return starts_with($msg, 'CENT ');
    }

    public function handle(ReceivedMessage $message): string
    {
        $response = $this->client->request('POST', env('CENT_URL'), ['json' => [
            'moReference' => Input::get('messageId'),
            'serviceNumber' => env('MO'),
            'message' => $message->message,
            'subscriber' => $message->address,
            'price' => env('MO_PRICE'),
        ]]);

        abort_unless($response->getStatusCode() === 200, $response->getStatusCode(), $response->getReasonPhrase());

        $jason = json_decode($response->getBody());

        if ($jason->message === null) {
            return 'Thanks';
        }

        return (string)$jason->message;
    }

}
