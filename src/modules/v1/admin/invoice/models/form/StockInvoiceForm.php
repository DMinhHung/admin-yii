<?php

namespace app\modules\v1\admin\invoice\models\form;

use Yii;
use app\modules\v1\admin\invoice\models\StockInvoice;

class StockInvoiceForm extends StockInvoice
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [["code", "type", "user_id"], "required"],
            [["code"], "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_PENDING],
        ]);
    }
}