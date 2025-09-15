<?php

namespace app\modules\v1\admin\product\models;

use app\models\Item as BaseItem;

class Item extends BaseItem
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'brand',
            'category'
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
}