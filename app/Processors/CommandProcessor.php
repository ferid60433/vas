<?php

namespace Vas\Processors;

use Illuminate\Support\Str;
use Vas\ReceivedMessage;
use Vas\Service;

class CommandProcessor extends Processor
{
    /** @var Service */
    protected $service;

    public function isHandleable(ReceivedMessage $message): bool
    {
        try {
            $fullMessage = $this->trimThenUpper($message->message);

            $this->service = Service::lookupService(Str::after($fullMessage, '@'));

            $broadcast = Str::after($fullMessage, ',');

            return $this->shouldHandle($message, $fullMessage, $broadcast);
        } catch (\Throwable $throwable) {
            $this->getLogger()->debug(CommandProcessor::class, $throwable);

            return false;
        }
    }

    /**
     * @param ReceivedMessage $message
     * @param $fullMessage
     * @param $broadcast
     *
     * @return bool
     */
    protected function shouldHandle(ReceivedMessage $message, $fullMessage, $broadcast): bool
    {
        return
            // command starter
            Str::startsWith($fullMessage, '@') &&

            // only enabled for Admin/Owner
            Str::endsWith($message->address, env('OWNER_ADDRESS')) &&

            // Service must be found
            $this->service !== null &&

            // Message must not be empty
            Str::length($broadcast) > 0;
    }

    public function handle(ReceivedMessage $message): string
    {
        // TODO: broadcast messages

        return env('MESSAGE_OWNER_COMMAND');
    }

}
