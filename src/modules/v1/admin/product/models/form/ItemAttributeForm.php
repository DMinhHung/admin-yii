<?php

namespace app\modules\v1\admin\product\models\form;

use Yii;
use app\modules\v1\admin\product\models\ItemAttribute;

class ItemAttributeForm extends ItemAttribute
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ["name", "required"],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}