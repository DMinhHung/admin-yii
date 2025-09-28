<?php

namespace app\modules\v1\admin\invoice\models;

use app\models\ItemVariant;
use app\models\StockInvoiceItem as BaseStockInvoiceItem;
class StockInvoiceItem extends BaseStockInvoiceItem
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'product_variant' => "productVariant"
        ]);
    }

    public function getProductVariant()
    {
        return $this->hasMany(ItemVariant::class, ['id' => 'product_variant_id']);
    }
}