<?php

namespace Vas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizedRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
}
