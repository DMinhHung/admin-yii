<?php

namespace app\models;

use \app\models\base\CartItem as BaseCartItem;

/**
 * This is the model class for table "cart_items".
 */
class CartItem extends BaseCartItem
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }
}
