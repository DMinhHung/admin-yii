<?php

namespace app\modules\v1\end_user\product\models;

use app\models\Item as BaseItem;

class Item extends BaseItem
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'brand',
            'category',
            'item_variant' => 'itemVariant',
        ]);
    }

    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getItemVariant()
    {
        return $this->hasMany(ItemVariant::class, ['item_id' => 'id']);
    }
}