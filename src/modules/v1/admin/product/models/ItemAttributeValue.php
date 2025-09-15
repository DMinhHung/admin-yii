<?php

namespace app\modules\v1\admin\product\models;

use app\models\ItemAttributeValue as BaseItemAttributeValue;

class ItemAttributeValue extends BaseItemAttributeValue
{
    public function fields()
    {
        return [
            'value',
            'created_at',
            'updated_at'
        ];
    }
}