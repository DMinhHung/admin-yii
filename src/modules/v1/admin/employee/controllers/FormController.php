<?php

namespace app\modules\v1\admin\employee\controllers;

use Yii;
use yii\db\Exception;
use yii\rest\Controller;
use yii\web\HttpException;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\employee\models\Employee;
use app\modules\v1\admin\employee\models\form\EmployeeForm;
use app\modules\v1\admin\employee\models\search\EmployeeSearch;


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
                $item = new EmployeeForm();
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

    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            $id = $request->post('id');
            if (!empty($id)) {
                $item = EmployeeForm::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->load($data);
                    if ($item->validate() && $item->save()) {
                        return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(false, $item->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(false, null, "CUSTOMER EMPTY! ");
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
                $item = Employee::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    $item->status = Employee::STATUS_DELETED;
                    $item->save(false);
                    return ResponseBuilder::json(true, $item, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, null, "DATA EMPTY! ");
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
                $item = Employee::find()->where(['id' => $id])->one();
                if (!empty($item)) {
                    return ResponseBuilder::json(true, $item, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(false, null, "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new EmployeeSearch())->search(Yii::$app->request->queryParams));
    }
}
