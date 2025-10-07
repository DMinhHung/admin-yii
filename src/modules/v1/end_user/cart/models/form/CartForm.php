<?php


namespace app\modules\v1\end_user\cart\models\form;

use Yii;
use app\modules\v1\end_user\cart\models\Cart;

class CartForm extends Cart
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ["customer_id", "required"],
            ["customer_id", "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}