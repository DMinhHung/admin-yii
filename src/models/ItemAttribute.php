<?php

namespace app\models;

use \app\models\base\ItemAttribute as BaseItemAttribute;

/**
 * This is the model class for table "item_attribute".
 */
class ItemAttribute extends BaseItemAttribute
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return '';
    }
}
