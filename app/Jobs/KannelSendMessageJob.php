<?php

namespace Vas\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Vas\Util\GsmEncoding;

class KannelSendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    protected $message;

    /** @var Collection */
    protected $addresses;

    /**
     * Create a new job instance.
     *
     * @param string $message
     * @param Collection $addresses
     */
    public function __construct(string $message, Collection $addresses)
    {
        $this->message = $message;
        $this->addresses = $addresses;
    }

    /**
     * Execute the job.
     *
     * @param Client $client
     * @return void
     */
    public function handle(Client $client)
    {
        $defaults = $this->defaults();

        $this->addresses->map(function ($address) use ($client, $defaults) {
            $sentMessage = \Vas\SentMessage::create([
                'address' => $address,
                'message' => $this->message,
            ]);

            $instance = [
                'to' => $sentMessage->full_address,
                'dlr-url' => urlencode(urldecode(route('kannel.delivered', [
                    'id' => $sentMessage->id,
                    'status' => '%d',
                ]))),
            ];

            $client->get('http://localhost:13013/cgi-bin/sendsms', [
                'query' => urldecode(http_build_query($defaults + $instance)),
            ]);
        });
    }

    /**
     * @return array
     */
    protected function defaults(): array
    {
        $query = [
            'user' => env('KANNEL_USER'),
            'password' => env('KANNEL_PASSWORD'),
            'from' => env('MO'),
            'text' => $this->message,
            'smsc' => 'mtSmsc',
            'mClass' => '1',
            'dlr-mask' => 3,
        ];

        if ($this->isUnicode()) {
            $query['charset'] = 'UTF-8';
            $query['coding'] = '2';
        }

        return $query;
    }

    /**
     * @return bool
     */
    protected function isUnicode(): bool
    {
        return !GsmEncoding::isGsm0338($this->message);
    }
}