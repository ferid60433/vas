<?php

namespace Vas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribersImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'service' => 'required|exists:services,id',
            'upload' => 'required|file',
        ];
    }
}
