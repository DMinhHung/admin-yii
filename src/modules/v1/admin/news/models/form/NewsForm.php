<?php


namespace app\modules\v1\admin\news\models\form;

use Yii;
use app\modules\v1\admin\news\models\News;

class NewsForm extends News
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [["title", "content"], "required"],
            ["title", "unique", 'filter' => ["!=", "status", self::STATUS_DELETED]],
            ["status", "default", "value" => self::STATUS_ACTIVE],
        ]);
    }
}