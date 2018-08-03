<?php

namespace Vas\Http\Controllers\Api;

use Vas\Http\Controllers\Controller;
use Vas\ReceivedMessage;
use Vas\SentMessage;

class InboxController extends Controller
{
    public function index()
    {
        return SentMessage::all();
    }

    public function show(ReceivedMessage $inbox)
    {
        return $inbox;
    }
}
