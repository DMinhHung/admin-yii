<?php

namespace app\modules\v1\admin\product\models\form;

use Yii;
use app\modules\v1\admin\product\models\Item;

class ItemVariantForm extends Item
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [["item_id", "sku", "stock"], "required"],
            [["sku"], "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}