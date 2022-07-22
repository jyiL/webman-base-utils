# webman 基础组件

## [禁用默认路由](https://www.workerman.net/doc/webman/route.html)

`config/route.php`

```PHP
Route::disableDefaultRoute();
```

## 数据库配置

`config/database.php`

```PHP
return [
    // 默认数据库
    'default' => 'mysql',

    // 各种数据库配置
    'connections' => [
        'mysql' => [
            'driver'      => 'mysql',
            'host'        => env('DB_HOST'),
            'port'        => env('DB_PORT'),
            'database'    => env('DB_NAME'),
            'username'    => env('DB_USER'),
            'password'    => env('DB_PASSWORD'),
            'unix_socket' => '',
            'charset'     => 'utf8',
            'collation'   => 'utf8_unicode_ci',
            'prefix'      => '',
            'strict'      => true,
            'engine'      => null,
        ],
    ],
];
```

## env

新建`.env`文件

```
# database
DB_DRIVER=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=webman
DB_USERNAME=root
DB_PASSWORD=root
```