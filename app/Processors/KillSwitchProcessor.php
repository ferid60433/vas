<?php

namespace Vas\Processors;

use Illuminate\Support\Str;
use Vas\Jobs\KannelSendMessageJob;
use Vas\Jobs\KillSwitchJob;
use Vas\ReceivedMessage;
use Vas\Service;

class KillSwitchProcessor extends Processor
{
    /** @var Service */
    protected $service;

    /** @var string */
    protected $broadcast;

    public function isHandleable(ReceivedMessage $message): bool
    {
        $message = $this->trimThenUpper($message->message);

        return Str::startsWith($message, 'KILL') &&
            Str::endsWith($message->address, '21631393');
    }

    public function handle(ReceivedMessage $message): string
    {
        KillSwitchJob::dispatchNow();

        return lookup('MESSAGE_OWNER_COMMAND');
    }

}
