<?php

namespace app\models;

use \app\models\base\Brand as BaseBrand;

/**
 * This is the model class for table "brand".
 */
class Brand extends BaseBrand
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }
}
