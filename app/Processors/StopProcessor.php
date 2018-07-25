<?php

namespace Vas\Processors;

use Illuminate\Support\Str;
use Vas\ReceivedMessage;
use Vas\Subscriber;

class StopProcessor extends Processor
{

    public function isHandleable(ReceivedMessage $message): bool
    {
        $msg = $this->trimThenUpper($message->message);

        return Str::startsWith($msg, 'S');
    }

    public function handle(ReceivedMessage $message): string
    {
        $subs = Subscriber::where('address', $message->address)->get();

        if ($subs->count() <= 0) {
            return env('MESSAGE_NOT_SUBSCRIBED_YET');
        } else {
            $subs->first()->delete();

            return env('MESSAGE_STOP');
        }
    }

}
