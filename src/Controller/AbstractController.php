<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/21
 * Time: 15:32
 * Email: avril.leo@yahoo.com
 */

namespace Jyil\WebmanBaseUtils\Controller;

class AbstractController extends Controller
{
    /**
     * 脚手架操作的model对象名
     *
     * @var string
     */
    protected $model_class;
}