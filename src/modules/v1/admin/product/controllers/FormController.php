<?php

namespace app\modules\v1\admin\product\controllers;

use Yii;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\brand\models\Brand;
use app\modules\v1\admin\brand\models\form\BrandForm;
use app\modules\v1\admin\brand\models\search\BrandSearch;

class FormController extends Controller
{

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $brand = new BrandForm();
                $brand->load($data);
                if ($brand->validate() && $brand->save()) {
                    return ResponseBuilder::json(true, $brand, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, $brand->getErrors(), "VALIDATE FAIL! ");
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
                $brand = BrandForm::find()->where(['id' => $id])->one();
                if (!empty($brand)) {
                    $brand->load($data);
                    if ($brand->validate() && $brand->save()) {
                        return ResponseBuilder::json(true, $brand, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(true, $brand->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(true, $brand->getErrors(), "BRAND EMPTY! ");
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
                $brand = Brand::find()->where(['id' => $id])->one();
                if (!empty($brand)) {
                    $brand->status = Brand::STATUS_DELETED;
                    $brand->save(false);
                    return ResponseBuilder::json(true, $brand, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, $brand->getErrors(), "BRAND EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
    }

    public function actionView(int $id)
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id');
            if (!empty($id)) {
                $brand = Brand::find()->where(['id' => $id])->one();
                if (!empty($brand)) {
                    return ResponseBuilder::json(true, $brand, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(true, $brand->getErrors(), "BRAND EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new BrandSearch())->search(Yii::$app->request->queryParams));
    }
}
