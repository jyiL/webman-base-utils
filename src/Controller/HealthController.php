<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/22
 * Time: 15:08
 * Email: avril.leo@yahoo.com
 */

namespace Jyil\WebmanBaseUtils\Controller;

use support\Db;
use support\Redis;

class HealthController extends AbstractController
{
    public function index()
    {
        $db = Db::connection()->getPdo();
        $redis = Redis::connection();

        return $this->success([
            'db' => $db ? true : false,
            'redis' => $redis ? true : false,
        ]);
    }
}