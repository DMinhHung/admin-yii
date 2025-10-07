<?php


namespace app\modules\v1\end_user\cart\models;

use app\models\Cart as BaseCart;

class Cart extends BaseCart
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'cart_item' => 'cartItem',
        ]);
    }

    public function getCartItem()
    {
        return $this->hasOne(CartItem::class, ['id' => 'cart_id']);
    }
}