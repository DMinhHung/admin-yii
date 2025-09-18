<?php

namespace app\modules\v1\admin\product\models;

use app\models\ItemVariant as BaseItemVariant;

class ItemVariant extends BaseItemVariant
{
    public function fields()
    {
        return [
            'name',
            'sku',
            'price',
            'stock',
            'item',
            'attributes' => function () {
                return array_map(function ($attr) {
                    return [
                        'name' => $attr->itemAttribute->name ?? null,
                        'value' => $attr->valueRelation->value ?? null,
                    ];
                }, $this->itemVariantAttribute);
            },
        ];
    }

    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
    }

    public function getItemVariantAttribute()
    {
        return $this->hasMany(\app\modules\v1\admin\product\models\ItemVariantAttribute::class, ['item_variant_id' => 'id']);
    }
}