<?php

namespace Vas\Http\Controllers\Api;

use Psr\Log\LoggerInterface;
use Vas\Http\Controllers\Controller;
use Vas\Http\Requests\Kannel;
use Vas\Processors\Processor;
use Vas\ReceivedMessage;
use Vas\SentMessage;
use Vas\Util\KannelResponsable;

class KannelController extends Controller
{
    /**
     * @param Kannel\ReceivedRequest $request
     * @param Processor $processor
     *
     * @return KannelResponsable
     */
    public function received(Kannel\ReceivedRequest $request, Processor $processor, LoggerInterface $logger)
    {
        $logger->critical('req:- ', [$request->all(), $request->headers]);

        $receivedMessage = ReceivedMessage::create([
            'address' => $request->get('from'),
            'message' => $request->get('content') ?? '',
        ]);

        $sentMessage = SentMessage::create([
            'address' => $request->get('from'),
            'message' => $processor($receivedMessage),
        ]);

        return new KannelResponsable($sentMessage);
    }

    public function delivered(Kannel\DeliveredRequest $request)
    {
        $sentMessage = SentMessage::find((int)$request->get('id'));
        $sentMessage->delivery_status = (int)$request->get('status');
        $sentMessage->save();

        return response('nice');
    }

}
