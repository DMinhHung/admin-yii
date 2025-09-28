<?php

namespace app\modules\v1\admin\product\controllers;

use Yii;
use yii\db\Exception;
use yii\web\HttpException;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\product\models\ItemVariant;
use app\modules\v1\admin\product\models\form\ItemVariantForm;
use app\modules\v1\admin\product\models\ItemVariantAttribute;
use app\modules\v1\admin\product\models\search\ItemVariantSearch;


class ItemVariantController extends Controller
{
    /**
     * @throws Exception
     * @throws HttpException
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $item = new ItemVariantForm();
                $item->load($data);
                if ($item->validate() && $item->save()) {
                    if (!empty($data['item_attribute_id']) && !empty($data['item_attribute_value_id'])) {
                        foreach ($data['item_attribute_id'] as $k => $attrId) {
                            $attrValueId = $data['item_attribute_value_id'][$k] ?? null;
                            if ($attrValueId) {
                                $iva = new ItemVariantAttribute();
                                $iva->item_variant_id = $item->id;
                                $iva->item_attribute_id = $attrId;
                                $iva->item_attribute_value_id = $attrValueId;
                                $iva->save(false);
                            }
                        }
                    }
                    return ResponseBuilder::json(true, $item, "CREATE SUCCESS!");
                }
                return ResponseBuilder::json(false, $item->getErrors(), "VALIDATE FAIL!");
            }
            return ResponseBuilder::json(false, null, "MISSING PARAMS!");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST!");
    }

    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            $id = $request->post('id');
            if (!empty($id)) {
                $item = ItemVariantForm::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->load($data);
                    if ($item->validate() && $item->save()) {
                        ItemVariantAttribute::deleteAll(['item_variant_id' => $item->id]);
                        if (!empty($data['item_attribute_id']) && !empty($data['item_attribute_value_id'])) {
                            foreach ($data['item_attribute_id'] as $k => $attrId) {
                                $valueId = $data['item_attribute_value_id'][$k] ?? null;
                                if ($valueId) {
                                    $iva = new ItemVariantAttribute();
                                    $iva->item_variant_id = $item->id;
                                    $iva->item_attribute_id = $attrId;
                                    $iva->item_attribute_value_id = $valueId;
                                    $iva->save(false);
                                }
                            }
                        }
                        return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(false, $item->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(false, null, "ITEM EMPTY! ");
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
                $item = ItemVariant::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->status = ItemVariant::STATUS_DELETED;
                    $item->save(false);
                    return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, null, "ITEM EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
    }

    public function actionGet(int $id)
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id');
            if (!empty($id)) {
                $item = ItemVariant::find()->where(['item_id' => $id])->all();
                if (!empty($item)) {
                    return ResponseBuilder::json(true, $item, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(false, null, "ITEM EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

    public function actionList()
    {
        return ResponseBuilder::json(true, (new ItemVariantSearch())->search(Yii::$app->request->queryParams));
    }
}
