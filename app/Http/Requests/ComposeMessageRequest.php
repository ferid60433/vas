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
        if (env('NON_VAS')) {
            return [
                'numbers' => 'required|min:8',
                'message' => 'required|min:5',
            ];
        }

        return [
            'plus' => 'required_without:confirm|min:1',
            'confirm' => 'required_without:plus|min:1',

            'plus.*' => 'exists:services,letter',
            'minus.*' => 'exists:services,letter',
            'confirm.*' => 'exists:services,letter',

            'message' => 'required|min:5',
            'isPromo' => 'sometimes|boolean',
        ];
    }
}
