<?php

namespace app\modules\v1\admin\customer\models\form;

use Yii;
use app\modules\v1\admin\customer\models\Customer;

class CustomerForm extends Customer
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [["name", "phone", "email"], "required"],
            [["name"], "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
            ["current_debt", "default", "value" => 0],
        ]);
    }
}