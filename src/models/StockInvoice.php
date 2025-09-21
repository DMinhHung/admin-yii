<?php

namespace app\models;

use \app\models\base\StockInvoice as BaseStockInvoice;

/**
 * This is the model class for table "stock_invoice".
 */
class StockInvoice extends BaseStockInvoice
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;
    const STATUS_DELETED = -99;
    const TYPE_IN = 1;
    const TYPE_OUT = 2;
    const TYPE_DESTROY = 3;


    public function formName()
    {
        return '';
    }
}
