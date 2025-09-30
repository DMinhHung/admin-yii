<?php


namespace app\modules\v1\admin\invoice\models\form;

use Yii;
use app\modules\v1\admin\invoice\models\Receipt;

class ReceiptForm extends Receipt
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [["receipt_no", "payer_name", "payer_phone"], "required"],
            [["receipt_no"], "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}