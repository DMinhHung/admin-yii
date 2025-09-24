<?php

namespace app\modules\v1\admin\supplier\controllers;

use Yii;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\supplier\models\Vendor;
use app\modules\v1\admin\supplier\models\form\VendorForm;
use app\modules\v1\admin\supplier\models\search\VendorSearch;
use yii\db\Exception;
use yii\web\HttpException;


class FormController extends Controller
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
                $item = new VendorForm();
                $item->load($data);
                if ($item->validate() && $item->save()) {
                    return ResponseBuilder::json(true, $item, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, null, "VALIDATE FAIL! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");

    }

    /**
     * @throws HttpException
     */
    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            $id = $request->post('id');
            if (!empty($id)) {
                $item = VendorForm::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->load($data);
                    if ($item->validate() && $item->save()) {
                        return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(false, null, "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(false, null, "CUSTOMER EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
    }

    /**
     * @throws HttpException
     */
    public function actionDelete()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            $id = $data['id'];
            if (!empty($id)) {
                $item = Vendor::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->status = Vendor::STATUS_DELETED;
                    $item->save(false);
                    return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, null, "BRAND EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
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
                $item = Vendor::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    return ResponseBuilder::json(true, $item, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(false, null, "BRAND EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

    /**
     * @throws HttpException
     */
    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new VendorSearch())->search(Yii::$app->request->queryParams));
    }
}
