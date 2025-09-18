<?php

namespace app\modules\v1\admin\product\models;

use app\models\ItemAttributeValue as BaseItemAttributeValue;

class ItemAttributeValue extends BaseItemAttributeValue
{
    public function fields()
    {
        return [
            'id',
            'value',
            'created_at',
            'updated_at'
        ];
    }
}