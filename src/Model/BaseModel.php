<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/22
 * Time: 15:49
 * Email: avril.leo@yahoo.com
 */

namespace Jyil\WebmanBaseUtils\Model;

use support\Model;

class BaseModel extends Model
{
    const STATUS_YES = 1;

    const STATUS_NOT = 0;

    public static $status = [
        self::STATUS_YES => '启用',
        self::STATUS_NOT => '禁用',
    ];
}