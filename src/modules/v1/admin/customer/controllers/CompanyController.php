<?php


namespace app\modules\v1\admin\customer\controllers;

use Yii;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\customer\models\CustomerCompany;
use app\modules\v1\admin\customer\models\form\CustomerCompanyForm;
use app\modules\v1\admin\customer\models\search\CustomerCompanySearch;

class CompanyController extends Controller
{

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $brand = new CustomerCompanyForm();
                $brand->load($data);
                if ($brand->validate() && $brand->save()) {
                    return ResponseBuilder::json(true, $brand, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, $brand->getErrors(), "VALIDATE FAIL! ");
            }
            return ResponseBuilder::json(false, null, "MISSING PARAMS! ");
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
                $brand = CustomerCompanyForm::find()->where(['id' => $id])->one();
                if (!empty($brand)) {
                    $brand->load($data);
                    if ($brand->validate() && $brand->save()) {
                        return ResponseBuilder::json(true, $brand, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(false, $brand->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(false, $brand->getErrors(), "CUSTOMER EMPTY! ");
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
                $brand = CustomerCompany::find()->where(['id' => $id])->one();
                if (!empty($brand)) {
                    $brand->status = CustomerCompany::STATUS_DELETED;
                    $brand->save(false);
                    return ResponseBuilder::json(true, $brand, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, $brand->getErrors(), "DATA EMPTY! ");
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
                $brand = CustomerCompany::find()->where(['id' => $id])->one();
                if (!empty($brand)) {
                    return ResponseBuilder::json(true, $brand, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(false, $brand->getErrors(), "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new CustomerCompanySearch())->search(Yii::$app->request->queryParams));
    }
}
