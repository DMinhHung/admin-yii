<?php

namespace app\modules\v1\end_user\banner\controllers;

use Yii;
use yii\web\HttpException;
use app\helpers\ResponseBuilder;
use app\modules\v1\end_user\banner\models\search\BannerSearch;


class FormController extends Controller
{
    /**
     * @throws HttpException
     */
    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new BannerSearch())->search(Yii::$app->request->queryParams));
    }

}
