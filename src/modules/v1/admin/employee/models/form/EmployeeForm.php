<?php

namespace app\modules\v1\admin\employee\models\form;

use Yii;
use app\modules\v1\admin\employee\models\Employee;

class EmployeeForm extends Employee
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [["username", "email", "phone", "gender"], "required"],
            [["username", "email", "phone"], "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}