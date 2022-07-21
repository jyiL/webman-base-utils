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
use support\Request;
use support\Response;

abstract class Controller
{
    /**
     * request对象
     *
     * @var Request
     */
    protected $request;

    /**
     * response对象
     *
     * @var Response
     */
    protected $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;

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
        $http_request = $this->container->get(RequestInterface::class);
        return $http_request->getServerParams()['request_uri'] ?? '';
    }

    /**
     * 返回成功的请求
     *
     * @param array  $data
     * @param string $message
     *
     * @return array
     */
    public function success(array $data = [], $message = '操作成功')
    {
        $response = [
            'code' => 0,
            'message' => $message,
            'payload' => $data ?: (object)[],
        ];
        Log::info('http.' . $this->getCalledSource(), $response);
        return $response;
    }

    /**
     * @param int         $code
     * @param string|null $message
     *
     * @return array
     */
    public function fail(int $code = -1, ?string $message = null)
    {
        $response = [
            'code' => $code,
//            'message' => $message ?: ErrorCode::getMessage($code),
            'payload' => (object)[],
        ];
        Log::info('http.' . $this->getCalledSource(), $response);
        return $response;
    }
}