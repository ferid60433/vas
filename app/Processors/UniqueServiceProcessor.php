<?php

namespace Vas\Processors;

use Vas\ReceivedMessage;
use Vas\Service;

class UniqueServiceProcessor extends DefaultProcessor
{
    public function handle(ReceivedMessage $message): string
    {
        $service = Service::first();

        $service->subscribers()->withTrashed()->updateOrCreate(
            [ // find with
                'service_id' => $service->id,
                'address' => $message->address,
            ],
            [ // update with
                'deleted_at' => null,
            ]
        );

        return $service->confirmation_message;
    }

}
