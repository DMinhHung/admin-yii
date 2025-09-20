<?php

namespace app\modules\v1\admin\supplier\models\form;

use Yii;
use app\modules\v1\admin\supplier\models\Vendor;

class VendorForm extends Vendor
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [["name", "phone", "email", "city", "company_name"], "required"],
            [["name"], "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}