<?php

namespace app\modules\v1\admin\product\models\form;

use Yii;
use app\modules\v1\admin\product\models\ItemAttribute;

class ItemVariantAttributeForm extends ItemAttribute
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ["item_variant_id", "item_attribute_id", "item_attribute_value_id", "required"],
        ]);
    }
}