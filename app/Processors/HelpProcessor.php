<?php

namespace Vas\Processors;

use Illuminate\Support\Str;
use Vas\ReceivedMessage;

class HelpProcessor extends Processor
{

    public function isHandleable(ReceivedMessage $message): bool
    {
        $msg = $this->trimThenUpper($message->message);

        return Str::startsWith($msg, 'H');
    }

    public function handle(ReceivedMessage $message): string
    {
        return lookup('MESSAGE_HELP');
    }

}
