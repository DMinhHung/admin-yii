<?php

namespace app\models;

use \app\models\base\News as BaseNews;

/**
 * This is the model class for table "news".
 */
class News extends BaseNews
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }
}
