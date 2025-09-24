<?php

namespace app\models;

use \app\models\base\Employee as BaseEmployee;

/**
 * This is the model class for table "employee".
 */
class Employee extends BaseEmployee
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }
}
