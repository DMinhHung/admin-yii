<?php

namespace app\models;

use \app\models\base\Vendor as BaseVendor;

/**
 * This is the model class for table "vendor".
 */
class Vendor extends BaseVendor
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }
}
