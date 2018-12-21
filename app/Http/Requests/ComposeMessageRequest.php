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
            'services' => 'required_without:numbers|min:1',
            'services.*' => 'required_without:numbers|exists:services,letter',

            'numbers' => 'required_without:services',

            'message' => 'required|min:5',
            'isPromo' => 'sometimes|boolean',
        ];
    }
}
