<?php

namespace app\modules\v1\end_user\cart\controllers;

use Yii;
use yii\web\HttpException;
use app\helpers\ResponseBuilder;
use app\modules\v1\end_user\cart\models\search\CartSearch;


class FormController extends Controller
{
    /**
     * @throws HttpException
     */
    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new CartSearch())->search(Yii::$app->request->queryParams));
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $banner = new BannerForm();
                $banner->load($data);
                if ($banner->validate() && $banner->save()) {
                    return ResponseBuilder::json(true, $banner, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, $banner->getErrors(), "VALIDATE FAIL! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");

    }

    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            $id = $request->post('id');
            if (!empty($id)) {
                $banner = BannerForm::find()->where(['id' => $id])->one();
                if (!empty($banner)) {
                    $banner->load($data);
                    if ($banner->validate() && $banner->save()) {
                        return ResponseBuilder::json(true, $banner, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(true, $banner->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(true, [], "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
    }

    public function actionDelete()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            $id = $data['id'];
            if (!empty($id)) {
                $banner = Banner::find()->where(['id' => $id])->one();
                if (!empty($banner)) {
                    $banner->status = Banner::STATUS_DELETED;
                    $banner->save(false);
                    return ResponseBuilder::json(true, $banner, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, [], "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
    }

}
