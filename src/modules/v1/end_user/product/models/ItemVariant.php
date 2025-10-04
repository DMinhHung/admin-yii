<?php

namespace app\modules\v1\end_user\product\models;

use app\models\ItemVariant as BaseItemVariant;

class ItemVariant extends BaseItemVariant
{
    public function fields()
    {
        return [
            'id',
            'name',
            'thumbnail',
            'sku',
            'price',
            'stock',
            'barcode',
            'attributes' => function () {
                return array_map(function ($attr) {
                    return [
                        'attribute_id' => $attr->itemAttribute->id ?? null,
                        'attribute_value_id' => $attr->valueRelation->id ?? null,
                        'name' => $attr->itemAttribute->name ?? null,
                        'value' => $attr->valueRelation->value ?? null,
                    ];
                }, $this->itemVariantAttribute);
            },
        ];
    }

    public function getItemVariantAttribute()
    {
        return $this->hasMany(\app\modules\v1\admin\product\models\ItemVariantAttribute::class, ['item_variant_id' => 'id']);
    }
}