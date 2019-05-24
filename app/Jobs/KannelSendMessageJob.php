<?php

namespace Vas\Jobs;

use DB;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Vas\SentMessage;
use Vas\Util\GsmEncoding;

class KannelSendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    protected $message;

    /** @var Collection */
    protected $addresses;

    /** @var bool */
    private $promotion;

    /**
     * Create a new job instance.
     *
     * @param string $message
     * @param Collection $addresses
     * @param bool $promotion
     */
    public function __construct(string $message, Collection $addresses, $promotion = false)
    {
        $this->message = $message;
        $this->addresses = $addresses;
        $this->promotion = $promotion;
    }

    /**
     * Execute the job.
     *
     * @param Client $client
     * @return void
     * @throws Exception
     */
    public function handle(Client $client)
    {
        if ($this->attempts() > 3) $this->delete();

        DB::beginTransaction();

        try {
            $defaults = $this->defaults();

            $this->addresses->map(function ($service_id, $address) use ($client, $defaults) {
                $sentMessage = SentMessage::create([
                    'address' => $address,
                    'from' => $this->promotion ? env('MO') : env('MT'),
                    'message' => $this->getMessage(),
                    'service_id' => $service_id ?? null,
                ]);

                $instance = [
                    'to' => $sentMessage->full_address,
                    'dlr-url' => trim(env('APP_URL'),
                            '/') . "/api/kannel/delivered?id={$sentMessage->id}&status=PERCENT_D",
                ];

                $client->get('http://' . env('KANNEL_HOST') . ':13013/cgi-bin/sendsms', [
                    'query' => Str::replaceLast('PERCENT_D', '%d', http_build_query($defaults + $instance)),
                ]);
            });

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }
    }
    
    protected function defaults(): array
    {
        $query = [
            'user' => env('KANNEL_USER'),
            'password' => env('KANNEL_PASSWORD'),
            'from' => $this->promotion ? env('MO') : env('MT'),
            'text' => $this->getMessage(),
            'smsc' => 'smsc',
            'mClass' => '1',
            'dlr-mask' => 31,
            //'coding' => '1', // Tele Kale ale new
        ];

        if ($this->isUnicode()) {
            $query['charset'] = 'UTF-8';
            $query['coding'] = '2';
        }

        return $query;
    }

    protected function isUnicode(): bool
    {
        return !GsmEncoding::isGsm0338($this->getMessage());
    }

    public function getMessage(): string
    {
        return $this->message ?? '';
    }
}
