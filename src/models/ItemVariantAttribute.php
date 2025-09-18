<?php

namespace app\models;

use \app\models\base\ItemVariantAttribute as BaseItemVariantAttribute;

/**
 * This is the model class for table "item_variant_attribute".
 */
class ItemVariantAttribute extends BaseItemVariantAttribute
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return '';
    }
}
