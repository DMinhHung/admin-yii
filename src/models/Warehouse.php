<?php

namespace app\models;

use \app\models\base\Warehouse as BaseWarehouse;

/**
 * This is the model class for table "warehouse".
 */
class Warehouse extends BaseWarehouse
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return '';
    }
}
