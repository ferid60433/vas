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
            'plus' => 'required_without:numbers|min:1',
            'plus.*' => 'required_without:numbers|exists:services,letter',
            'minus.*' => 'exists:services,letter',

            'numbers' => 'required_without:plus',

            'message' => 'required|min:5',
            'isPromo' => 'sometimes|boolean',
        ];
    }
}
