<?php

namespace app\modules\v1\admin\invoice\models\form;

use Yii;
use app\modules\v1\admin\invoice\models\Warehouse;

class WarehouseForm extends Warehouse
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ["name", "required"],
            [["name"], "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}