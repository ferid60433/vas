<?php

namespace Vas\Processors;

use Illuminate\Support\Str;
use Vas\ReceivedMessage;

class MoMessagesProcessor extends Processor
{
    public function isHandleable(ReceivedMessage $message): bool
    {
        return trim(trim(request()->get('to')), '0+') === env('MO');
    }

    public function handle(ReceivedMessage $message): string
    {
        return env('MESSAGE_MO');
    }

}
