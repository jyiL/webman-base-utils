<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/22
 * Time: 15:34
 * Email: avril.leo@yahoo.com
 */

use Webman\Route;

if (!function_exists('register_route')) {
    function register_route($prefix, $controller, $callable = null)
    {
        Route::group($prefix, function () use ($controller, $callable) {
            Route::get('/info', [$controller, 'info']);
            Route::get('/form', [$controller, 'form']);
//            Route::get('/{id}', [$controller, 'edit'])->where('id', '\d+');
            Route::get('/{id}', [$controller, 'edit']);
            Route::get('/list', [$controller, 'list']);
            Route::post('/form', [$controller, 'save']);
            Route::post('/delete', [$controller, 'delete']);
//            Route::post('/{id}', [$controller, 'save'])->where('id', '\d+');
            Route::post('/{id}', [$controller, 'save']);
            is_callable($callable) && $callable($controller);
        });
    }
}