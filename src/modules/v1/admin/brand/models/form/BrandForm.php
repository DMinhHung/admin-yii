<?php

namespace app\modules\v1\admin\brand\models\form;

use Yii;
use app\modules\v1\admin\brand\models\Brand;

class BrandForm extends Brand
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ["name", "required"],
            ["name", "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}