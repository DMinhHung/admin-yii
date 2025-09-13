<?php

namespace app\modules\v1\admin\category\models\form;

use Yii;
use app\modules\v1\admin\category\models\Category;

class CategoryForm extends Category
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ["name", "required"],
            ["name", "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}