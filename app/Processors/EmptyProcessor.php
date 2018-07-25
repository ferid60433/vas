<?php

namespace Vas\Processors;

use Illuminate\Support\Str;
use Vas\ReceivedMessage;

class EmptyProcessor extends Processor
{

    public function isHandleable(ReceivedMessage $message): bool
    {
        $msg = $this->trimThenUpper($message->message);

        return Str::length($msg) === 0;
    }

    public function handle(ReceivedMessage $message): string
    {
        return env('MESSAGE_EMPTY');
    }

}
