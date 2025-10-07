<?php

namespace app\models;

use \app\models\base\Cart as BaseCart;

/**
 * This is the model class for table "carts".
 */
class Cart extends BaseCart
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }
}
