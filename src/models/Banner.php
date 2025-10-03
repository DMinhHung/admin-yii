<?php

namespace app\models;

use \app\models\base\Banner as BaseBanner;

/**
 * This is the model class for table "banner".
 */
class Banner extends BaseBanner
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }
}
