<?php


namespace app\modules\v1\admin\invoice\controllers;

use Yii;
use yii\db\Exception;
use yii\web\HttpException;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\invoice\models\Payment;
use app\modules\v1\admin\invoice\models\form\PaymentForm;

class PaymentController extends Controller
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
                $item = new PaymentForm();
                $item->load($data);
                if ($item->validate() && $item->save()) {
                    return ResponseBuilder::json(true, $item, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, $item->getErrors(), "VALIDATE FAIL! ");
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
                $item = PaymentForm::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->load($data);
                    if ($item->validate() && $item->save()) {
                        return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(false, $item->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(false, $item->getErrors(), "DATA EMPTY! ");
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
                $item = Payment::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->status = Payment::STATUS_DELETED;
                    $item->save(false);
                    return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, $item->getErrors(), "DATA EMPTY! ");
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
                $item = Payment::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    return ResponseBuilder::json(true, $item, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(false, $item->getErrors(), "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

//    public function actionIndex()
//    {
//        return ResponseBuilder::json(true, (new WarehouseSearch())->search(Yii::$app->request->queryParams));
//    }
}
