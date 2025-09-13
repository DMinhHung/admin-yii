<?php

namespace app\models;

use \app\models\base\ItemAttributeValue as BaseItemAttributeValue;

/**
 * This is the model class for table "item_attribute_value".
 */
class ItemAttributeValue extends BaseItemAttributeValue
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;
}
