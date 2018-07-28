<?php

namespace Vas\Http\Requests;

class ServiceStoreRequest extends AuthorizedRequest
{
    public function rules()
    {
        return [
            'letter' => 'required|alpha_num|min:1|max:5|unique:services,letter',
            'code' => 'required|min:1|max:16|unique:services,code',
            'confirmation_message' => 'required|min:10',
        ];
    }
}
