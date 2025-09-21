<?php

namespace app\modules\v1\admin\invoice\models;

use app\models\StockCheck as BaseStockCheck;
class StockCheck extends BaseStockCheck
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'items' => "stockCheckItem",
        ]);
    }

    public function getStockCheckItem()
    {
        return $this->hasMany(StockCheckItem::class, ['check_id' => 'id']);
    }
}