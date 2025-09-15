<?php

namespace app\modules\v1\admin\product\models;

use app\models\ItemAttribute as BaseItemAttribute;

class ItemAttribute extends BaseItemAttribute
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'value' => 'attributeValue',
        ]);
    }

    public function getAttributeValue()
    {
        return $this->hasOne(ItemAttributeValue::class, ['attribute_id' => 'id']);
    }
}