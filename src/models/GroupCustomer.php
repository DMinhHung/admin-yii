<?php

namespace app\models;

use \app\models\base\GroupCustomer as BaseGroupCustomer;

/**
 * This is the model class for table "group_customer".
 */
class GroupCustomer extends BaseGroupCustomer
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }
}
