<?php

namespace Vas\Http\Requests\Kannel;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Log\Logger;

class Request extends FormRequest
{
    /** @var Logger */
    private $logger;

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

    protected function failedValidation(Validator $validator)
    {
        $this->logger->critical(static::class, [
            'this' => $this,
            'validator' => $validator,
            'request' => $this->all(),
        ]);

        abort(Response::HTTP_NOT_ACCEPTABLE);
    }
}
