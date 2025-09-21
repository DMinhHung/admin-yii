<?php

namespace app\models;

use \app\models\base\GroupVendor as BaseGroupVendor;

/**
 * This is the model class for table "group_vendor".
 */
class GroupVendor extends BaseGroupVendor
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }
}
