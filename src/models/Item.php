<?php

namespace app\models;

use \app\models\base\Item as BaseItem;

/**
 * This is the model class for table "item".
 */
class Item extends BaseItem
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return '';
    }
}
