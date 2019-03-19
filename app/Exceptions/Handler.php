<?php

namespace App\Exceptions;

use Exception;
use Photon\Foundation\Traits\MarshalTrait;
use Photon\Foundation\Traits\JobDispatcherTrait;
use Photon\Domains\Http\Jobs\JsonErrorResponseJob;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use MarshalTrait;
    use JobDispatcherTrait;

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
     * @param Exception $e
     * @throws Exception
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    public function render($request, Exception $e)
    {
        $message = $e->getMessage();
        $class = get_class($e);
        $code = $e->getCode();
        $trace = collect($e->getTrace());

        return $this->run(JsonErrorResponseJob::class, [
            'message' => $message,
            'code' => $class,
            'status' => ($code < 100 || $code >= 600) ? 400 : $code,
        ]);
    }
}
