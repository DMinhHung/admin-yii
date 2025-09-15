<?php

namespace app\models;

use \app\models\base\ItemVariant as BaseItemVariant;

/**
 * This is the model class for table "item_variant".
 */
class ItemVariant extends BaseItemVariant
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return '';
    }
}
