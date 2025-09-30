<?php

namespace app\models;

use \app\models\base\Payment as BasePayment;

/**
 * This is the model class for table "payment".
 */
class Payment extends BasePayment
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;
    const TYPE_PAYMENT_METHO_CASH = 1;
    const TYPE_PAYMENT_METHO_BANK = 2;
    const TYPE_PAYMENT_METHO_OTHER = 3;

    public function formName()
    {
        return '';
    }
}
