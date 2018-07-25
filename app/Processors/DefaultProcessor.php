<?php

namespace Vas\Processors;

use Vas\ReceivedMessage;

class DefaultProcessor extends Processor
{

    public function isHandleable(ReceivedMessage $message): bool
    {
        return true;
    }

    public function handle(ReceivedMessage $message): string
    {
        return env('MESSAGE_DEFAULT');
    }

}
