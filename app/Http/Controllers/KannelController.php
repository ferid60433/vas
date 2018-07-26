<?php

namespace Vas\Http\Controllers;

use Vas\Http\Requests\KannelDeliveredRequest;
use Vas\Http\Requests\KannelReceivedRequest;
use Vas\Processors\Processor;
use Vas\SentMessage;
use Vas\Util\KannelResponsable;

class KannelController extends Controller
{
    /**
     * @param KannelReceivedRequest $request
     * @param Processor $processor
     *
     * @return KannelResponsable
     */
    public function received(KannelReceivedRequest $request, Processor $processor)
    {
        $receivedMessage = \Vas\ReceivedMessage::create([
            'address' => $request->get('from'),
            'message' => $request->get('content') ?? '',
        ]);

        $sentMessage = \Vas\SentMessage::create([
            'address' => $request->get('from'),
            'message' => $processor($receivedMessage),
        ]);

        return new KannelResponsable($sentMessage);
    }

    public function delivered(KannelDeliveredRequest $request)
    {
        $sentMessage = SentMessage::find((int)$request->get('id'));
        $sentMessage->delivery_status = (int)$request->get('status');
        $sentMessage->save();

        return response('nice');
    }

}
