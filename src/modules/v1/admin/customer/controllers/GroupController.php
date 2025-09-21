<?php

namespace app\modules\v1\admin\customer\controllers;

use Yii;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\customer\models\GroupCustomer;
use app\modules\v1\admin\customer\models\search\GroupCustomerSearch;

class GroupController extends Controller
{

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $brand = new GroupCustomer();
                $brand->load($data);
                $brand->status = GroupCustomer::STATUS_ACTIVE;
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
                $brand = GroupCustomer::find()->where(['id' => $id])->one();
                if (!empty($brand)) {
                    $brand->load($data);
                    if ($brand->validate() && $brand->save()) {
                        return ResponseBuilder::json(true, $brand, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(true, $brand->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(true, $brand->getErrors(), "CUSTOMER EMPTY! ");
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
                $brand = GroupCustomer::find()->where(['id' => $id])->one();
                if (!empty($brand)) {
                    $brand->status = GroupCustomer::STATUS_DELETED;
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
                $brand = GroupCustomer::find()->where(['id' => $id])->one();
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
        return ResponseBuilder::json(true, (new GroupCustomerSearch())->search(Yii::$app->request->queryParams));
    }
}
