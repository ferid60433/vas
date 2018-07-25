<?php

namespace Vas\Processors;

use Vas\ReceivedMessage;
use Vas\Service;

class SubscriberProcessor extends Processor
{

    /** @var Service */
    protected $service;

    public function isHandleable(ReceivedMessage $message): bool
    {
        $msg = $this->trimThenUpper($message->message);

        $this->service = Service::lookupService($msg);

        return $this->service !== null;
    }

    public function handle(ReceivedMessage $message): string
    {
        $this->service->subscribers()->withTrashed()->updateOrCreate(
            [ // find with
                'service_id' => $this->service->id,
                'address' => $message->address,
            ],
            [ // update with
                'deleted_at' => null,
            ]
        );

        return $this->service->confirmation_message;
    }

}
