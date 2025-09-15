<?php

namespace app\modules\v1\admin\product\controllers;

use app\modules\v1\admin\product\models\ItemAttribute;
use Yii;
use app\helpers\ResponseBuilder;
use app\models\ItemAttributeValue;
use app\modules\v1\admin\product\models\form\ItemAttributeForm;
use app\modules\v1\admin\product\models\search\ItemAttributeSearch;


class ItemAttributeController extends Controller
{

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $attribute = new ItemAttributeForm();
                $attribute->load($data);
                if ($attribute->validate() && $attribute->save()) {
                    $value = new ItemAttributeValue();
                    $value->attribute_id = $attribute->id;
                    $value->status = ItemAttributeValue::STATUS_ACTIVE;
                    $value->load($data);
                    $value->save(false);
                    return ResponseBuilder::json(true, $attribute, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, $attribute->getErrors(), "VALIDATE FAIL! ");
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
                $item = ItemAttributeForm::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->load($data);
                    if ($item->validate() && $item->save()) {
                        $value = ItemAttributeValue::find()->where(['attribute_id' => $item->id])->one();
                        if (!empty($value)) {
                            $value->load($data);
                            $value->save(false);
                            return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                        }
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
                $item = ItemAttribute::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->status = ItemAttribute::STATUS_DELETED;
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
                $item = ItemAttribute::find()->where(['id' => $id])->one();
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
        return ResponseBuilder::json(true, (new ItemAttributeSearch())->search(Yii::$app->request->queryParams));
    }
}
