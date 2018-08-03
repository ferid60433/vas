<?php

namespace Vas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComposeMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'services' => 'required|min:1',
            'services.*' => 'exists:services,letter',
            'message' => 'required|min:5',
            'isPromo' => 'sometimes|boolean',
        ];
    }
}
