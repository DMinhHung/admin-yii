<?php

namespace app\models;

use \app\models\base\StockCheck as BaseStockCheck;

/**
 * This is the model class for table "stock_check".
 */
class StockCheck extends BaseStockCheck
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return '';
    }
}
