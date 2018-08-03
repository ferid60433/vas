<?php

namespace Vas\Http\Controllers\Api;

use Vas\Http\Controllers\Controller;
use Vas\SentMessage;

class OutboxController extends Controller
{
    public function index()
    {
        return SentMessage::all();
    }

    public function show(SentMessage $outbox)
    {
        return $outbox;
    }
}
