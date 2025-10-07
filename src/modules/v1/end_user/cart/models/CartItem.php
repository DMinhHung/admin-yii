<?php


namespace app\modules\v1\end_user\cart\models;

use app\models\CartItem as BaseCartItem;
use app\models\Item;

class CartItem extends BaseCartItem
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'item',
        ]);
    }

    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
    }
}