<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/22
 * Time: 15:19
 * Email: avril.leo@yahoo.com
 */

namespace Jyil\WebmanBaseUtils\Exception;

use Tinywan\ExceptionHandler\Handler;
use Throwable;
use Tinywan\Jwt\Exception\JwtTokenException;
use Tinywan\Jwt\Exception\JwtTokenExpiredException;
use Webman\Http\Response;
use Webman\Http\Request;

class HttpHandler extends Handler
{
    /**
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     */
    public function render(Request $request, Throwable $exception): Response
    {
        $this->config = array_merge($this->config, config('plugin.tinywan.exception-handler.app.exception_handler', []));

        $this->addRequestInfoToResponse($request);
        $this->solveAllException($exception);
        $this->addDebugInfoToResponse($exception);
        $this->triggerNotifyEvent($exception);
        $this->triggerTraceEvent($exception);

        if ($exception instanceof JwtTokenException || $exception instanceof JwtTokenExpiredException) {
            $code = 50000;

            if ($exception instanceof JwtTokenExpiredException) {
                $code = 50014;
            } else if ($exception instanceof JwtTokenException) {
                $code = 50008;
            }
            $responseBody = [
                'code' => $code,
                'status' => 'fail',
                'msg' => $this->errorMessage,
                'data' => $this->responseData,
            ];

            $header = array_merge([
                'Content-Type' => 'application/json;charset=utf-8',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Origin' => $request->header('Origin', '*'),
                'Access-Control-Allow-Methods' => '*',
                'Access-Control-Allow-Headers' => '*',
            ], $this->header);
            return new Response(200, $header, json_encode($responseBody));
        }

        return $this->buildResponse();
    }

    protected function buildResponse(): Response
    {
        $code = config('plugin.jyil.webman-base-utils.app.response_code_field');
        $message = config('plugin.jyil.webman-base-utils.app.response_msg_field');
        $data = config('plugin.jyil.webman-base-utils.app.response_data_field');

        $responseBody = [
            $code ?? 'code' => $this->errorCode,
            $message ?? 'msg' => $this->errorMessage,
            'status' => 'fail',
            $data ?? 'data' => $this->responseData,
        ];

        $header = array_merge([
            'Content-Type' => 'application/json;charset=utf-8',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => '*',
            'Access-Control-Allow-Headers' => '*',
        ], $this->header);
        return new Response($this->statusCode, $header, json_encode($responseBody));
    }
}