<?php

namespace Vas\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * Copied and modified from
     * https://stackoverflow.com/questions/28944097/laravel-5-handle-exceptions-when-request-wants-json
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($request->wantsJson() || $request->is('api/*')) {
            return $this->handleJsonException($e);
        }

        return parent::render($request, $e);
    }

    /**
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleJsonException(Exception $e): \Illuminate\Http\JsonResponse
    {
        $response = ['errors' => 'Sorry, something went wrong.'];

        if (config('app.debug')) {
            $response['exception'] = get_class($e);
            $response['message'] = $e->getMessage();
            $response['trace'] = $e->getTrace();
        }

        if ($e instanceof ValidationException) {
            $response['errors'] = $e->errors();
        }

        $status = Response::HTTP_BAD_REQUEST;

        if ($this->isHttpException($e)) {
            $status = $e->getStatusCode();
        }

        return response()->json($response, $status);
    }
}
