<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/21
 * Time: 15:39
 * Email: avril.leo@yahoo.com
 */

namespace Jyil\WebmanBaseUtils\Controller;

use support\Log;
use support\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class Controller
{
    protected $code;

    protected $message;

    protected $data;

    public function __construct()
    {
        $this->code = config('plugin.jyil.webman-base-utils.app.response_code_field');
        $this->message = config('plugin.jyil.webman-base-utils.app.response_msg_field');
        $this->data = config('plugin.jyil.webman-base-utils.app.response_data_field');

        if (method_exists($this, 'init')) {
            $this->init();
        }
    }

    protected function getCalledSource($get_arr = false)
    {
        $uri = $this->getRequestUri();
        $parts = array_filter(explode('/', $uri));
        if ($get_arr) {
            return array_values($parts);
        }
        return implode('.', $parts);
    }

    protected function getRequestUri()
    {
        return request()->uri();
    }

    /**
     * 返回成功的请求
     *
     * @param array  $data
     * @param string $message
     * @param int $code
     * @param array $headers
     *
     * @return Response
     */
    public function success(array $data = [], $message = '操作成功', int $code = 20000, array $headers = [])
    {
        $response = [
            "{$this->code}" => $code,
           'status' => 'ok',
            "{$this->message}" => $message,
            "{$this->data}" => $data ?: (object)[],
        ];
        Log::info('http.' . $this->getCalledSource(), $response);
        return response(
            json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),
            SymfonyResponse::HTTP_OK,
            array_merge([
                'Content-Type' => 'application/json',
            ], $headers)
        );
    }

    /**
     * @param int         $code
     * @param string|null $message
     * @param int|bool $httpStatus
     * @param array $headers
     *
     * @return Response
     */
    public function fail(int $code = 50000, ?string $message = null, $httpStatus = false, array $headers = [])
    {
        $response = [
            "{$this->code}" => $code,
            'status' => 'fail',
            "{$this->message}" => $message ?: SymfonyResponse::$statusTexts[$code],
            "{$this->data}" => (object)[],
        ];
        Log::info('http.' . $this->getCalledSource(), $response);
        return response(
            json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),
            $httpStatus ?: SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR,
            array_merge([
                'Content-Type' => 'application/json',
            ], $headers)
        );
    }
}