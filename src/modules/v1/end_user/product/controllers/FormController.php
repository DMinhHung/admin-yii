<?php

namespace app\modules\v1\end_user\product\controllers;

use Yii;
use yii\web\HttpException;
use app\helpers\ResponseBuilder;
use app\modules\v1\end_user\product\models\Item;
use app\modules\v1\end_user\product\models\search\ItemSearch;


class FormController extends Controller
{
    /**
     * @throws HttpException
     */
    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new ItemSearch())->search(Yii::$app->request->queryParams));
    }

    /**
     * @throws HttpException
     */
    public function actionView(int $id)
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id');
            if (!empty($id)) {
                $item = Item::find()->with(['brand', 'category', 'itemVariant'])->where(['id' => $id])->one();
                if (!empty($item)) {
                    return ResponseBuilder::json(true, $item, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(false, null, "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }
}
