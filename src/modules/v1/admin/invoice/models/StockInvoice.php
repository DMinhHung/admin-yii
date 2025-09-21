<?php

namespace app\modules\v1\admin\invoice\models;

use app\models\StockInvoice as BaseStockInvoice;
use app\modules\v1\admin\supplier\models\Vendor;

class StockInvoice extends BaseStockInvoice
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'items' => "stockInvoiceItem",
            'vendor'
        ]);
    }

    public function getStockInvoiceItem()
    {
        return $this->hasMany(StockInvoiceItem::class, ['invoice_id' => 'id']);
    }

    public function getVendor()
    {
        return $this->hasMany(Vendor::class, ['id' => 'vendor_id']);

    }
}