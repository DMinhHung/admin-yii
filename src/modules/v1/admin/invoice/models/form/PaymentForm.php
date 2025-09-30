<?php


namespace app\modules\v1\admin\invoice\models\form;

use Yii;
use app\modules\v1\admin\invoice\models\Payment;

class PaymentForm extends Payment
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [["payment_no", "payee_name", "payee_phone"], "required"],
            [["payment_no"], "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}