<?php

namespace Vas\Http\Requests\Kannel;

class ReceivedRequest extends Request
{
    public function rules()
    {
        return [
            'messageId' => 'required',
            'to' => 'required',
            'timestamp' => 'sometimes',

            'from' => 'required|min:8',
            'content' => 'sometimes',
        ];
    }
}
