<?php

namespace app\modules\v1\admin\product\models\form;

use Yii;
use app\modules\v1\admin\product\models\Item;

class ItemForm extends Item
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [["category_id", "brand_id", "name", "sku", "price", "cost", "stock"], "required"],
            [["name", "sku"], "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}