<?php

namespace app\modules\v1\admin\invoice\controllers;

use Yii;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\invoice\models\Warehouse;
use app\modules\v1\admin\invoice\models\form\WarehouseForm;
use app\modules\v1\admin\invoice\models\search\WarehouseSearch;

class WarehouseController extends Controller
{

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $item = new WarehouseForm();
                $item->load($data);
                if ($item->validate() && $item->save()) {
                    return ResponseBuilder::json(true, $item, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, $item->getErrors(), "VALIDATE FAIL! ");
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
                $item = WarehouseForm::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->load($data);
                    if ($item->validate() && $item->save()) {
                        return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(true, $item->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(true, $item->getErrors(), "BRAND EMPTY! ");
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
                $item = Warehouse::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->status = Warehouse::STATUS_DELETED;
                    $item->save(false);
                    return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, $item->getErrors(), "BRAND EMPTY! ");
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
                $item = Warehouse::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    return ResponseBuilder::json(true, $item, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(true, $item->getErrors(), "BRAND EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new WarehouseSearch())->search(Yii::$app->request->queryParams));
    }
}
