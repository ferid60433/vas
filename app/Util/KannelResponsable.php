<?php

namespace Vas\Util;

use Illuminate\Contracts\Support\Responsable;
use Vas\SentMessage;

class KannelResponsable implements Responsable
{

    /** @var SentMessage */
    private $message;

    public function __construct(SentMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $r = \response($this->message->message)
            ->header('X-Kannel-SMSC', 'mtSmsc')
            ->header('X-Kannel-From', env('MO'))
            ->header('X-Kannel-DLR-Mask', '3')
            ->header('X-Kannel-DLR-Url', $this->generateDlrUrl());

        if ($this->isMessageUnicode()) {
            $r->header('Content-Type', 'text/html; charset=UTF-8');
            $r->header('X-Kannel-Coding', '2');
        } else {
            $r->header('Content-Type', 'text/html; charset=ISO-8859-1');
        }

        return $r;
    }

    protected function generateDlrUrl(): string
    {
        $dlrUrl = route('kannel.delivered', [
            'id' => $this->message->id,
            'status' => '%d',
        ]);

        return urldecode($dlrUrl);
    }

    protected function isMessageUnicode(): bool
    {
        return !GsmEncoding::is_gsm0338($this->message);
    }

}
