<?php

namespace Vas\Http\Requests\Kannel;

class DeliveredRequest extends Request
{
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:sent_messages,id',
            'status' => 'required|integer|in:0,1,2',
        ];
    }

}
