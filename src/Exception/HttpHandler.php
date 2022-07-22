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
use Webman\Http\Response;

class HttpHandler extends Handler
{
    protected function buildResponse(): Response
    {
        $code = config('plugin.jyil.webman-base-utils.app.response_code_field');
        $message = config('plugin.jyil.webman-base-utils.app.response_msg_field');
        $data = config('plugin.jyil.webman-base-utils.app.response_data_field');

        $responseBody = [
            $code ?? 'code' => $this->errorCode,
            $message ?? 'msg' => $this->errorMessage,
            $data ?? 'data' => $this->responseData,
        ];

        $header = array_merge(['Content-Type' => 'application/json;charset=utf-8'], $this->header);
        return new Response($this->statusCode, $header, json_encode($responseBody));
    }
}