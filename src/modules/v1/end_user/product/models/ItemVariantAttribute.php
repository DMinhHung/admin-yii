<?php

namespace app\modules\v1\end_user\product\models;

use app\models\ItemVariantAttribute as BaseItemVariantAttribute;

class ItemVariantAttribute extends BaseItemVariantAttribute
{
    public function getItemAttribute()
    {
        return $this->hasOne(\app\models\ItemAttribute::class, ['id' => 'item_attribute_id']);
    }

    public function getValueRelation()
    {
        return $this->hasOne(\app\models\ItemAttributeValue::class, ['id' => 'item_attribute_value_id']);
    }
}