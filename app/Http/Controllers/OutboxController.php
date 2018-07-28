<?php

namespace Vas\Http\Controllers;

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
