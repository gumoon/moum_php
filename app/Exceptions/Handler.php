<?php

namespace moum\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Debug\Exception\FlattenException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            $ret = array(
                'err_no' => 10000,
                'msg' => trans('errorcode.10000'),
                'data' => new \stdClass
            );
            return response()->json($ret, 401);
        }

        return redirect()->guest('login');
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse( ValidationException $e, $request)
    {
        // if ($e->response) {
        //     return $e->response;
        // }

        $errors = $e->validator->errors()->getMessages();

        if ($request->expectsJson()) {
            $ret = array(
                'err_no' => 10001,
                'msg' => trans('errorcode.10001'),
                'data' => $errors
            );
            return response()->json($ret, 422);
        }

        return redirect()->back()->withInput($request->input())->withErrors($errors);
    }

    /**
     * Prepare response containing exception render.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function prepareResponse($request, Exception $e)
    {
        //api请求，返回json格式的错误信息
        if($request->expectsJson())
        {
            $e = FlattenException::create($e);

            $ret = array(
                'err_no' => $e->getStatusCode(),
                'msg' => trans('errorcode.'.$e->getStatusCode()),
                'data' => new \stdClass
            );

            return response()->json($ret, $e->getStatusCode());
        }

        //默认的处理方式
        if ($this->isHttpException($e)) {
            return $this->toIlluminateResponse($this->renderHttpException($e), $e);
        } else {
            return $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);
        }
    }
}
