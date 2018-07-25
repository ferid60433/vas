<?php

namespace Vas\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Log\Logger;

class KannelReceivedRequest extends FormRequest
{

    /** @var Logger */
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

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
            'messageId' => 'required',
            'to' => 'required',
            'timestamp' => 'sometimes',

            'from' => 'required|min:8',
            'content' => 'sometimes',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->logger->critical(KannelReceivedRequest::class, [
            'this' => $this,
            'validator' => $validator,
            'request' => $this->all(),
        ]);

        abort(Response::HTTP_NOT_ACCEPTABLE);
    }

}
