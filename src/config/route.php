<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/22
 * Time: 14:53
 * Email: avril.leo@yahoo.com
 */

use Webman\Route;
use Jyil\WebmanBaseUtils\Controller\HealthController;

// 给所有OPTIONS请求设置跨域
Route::options('[{path:.+}]', function (){
    return response('');
});

Route::get('/heartbeat', [HealthController::class, 'index']);

