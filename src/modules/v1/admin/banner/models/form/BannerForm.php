<?php


namespace app\modules\v1\admin\banner\models\form;

use Yii;
use app\modules\v1\admin\brand\models\Brand;

class BannerForm extends Brand
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ["title", "required"],
            ["title", "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}