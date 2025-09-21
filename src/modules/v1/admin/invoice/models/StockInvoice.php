<?php

namespace app\modules\v1\admin\invoice\models;

use app\models\StockInvoice as BaseStockInvoice;
class StockInvoice extends BaseStockInvoice
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'items' => "stockInvoiceItem",
        ]);
    }

    public function getStockInvoiceItem()
    {
        return $this->hasMany(StockInvoiceItem::class, ['invoice_id' => 'id']);
    }

}