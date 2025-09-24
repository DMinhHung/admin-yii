<?php

namespace app\modules\v1\admin\customer\controllers;

use Yii;
use app\modules\v1\admin\customer\models\WorkSchedule;
use app\modules\v1\admin\customer\models\form\WorkScheduleForm;
use app\modules\v1\admin\customer\models\search\WorkScheduleSearch;
use app\helpers\ResponseBuilder;
use yii\rest\Controller;

class WorkScheduleController extends Controller
{
    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new WorkScheduleSearch())->search(Yii::$app->request->queryParams));
    }

    public function actionView(int $id)
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id');
            if (!empty($id)) {
                $brand = WorkSchedule::find()->where(['id' => $id])->one();
                if (!empty($brand)) {
                    return ResponseBuilder::json(true, $brand, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(true, $brand->getErrors(), "BRAND EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISSING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $form = new WorkScheduleForm();
                $form->load($data);
                if ($form->validate() && $form->save()) {
                    return ResponseBuilder::json(true, $form, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, $form->getErrors(), "VALIDATE FAIL! ");
            }
            return ResponseBuilder::json(false, [], 'MISSING PARAMS! ');
        }
        return ResponseBuilder::json(false, [], 'METHOD ALLOW POST! ');
    }

    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id');
            if (!empty($id)) {
                $form = WorkScheduleForm::find()->where(['id' => $id, 'status' => WorkSchedule::STATUS_ACTIVE])->one();
                if (!empty($form)) {
                    $form->load($request->post());
                    if ($form->validate() && $form->save()) {
                        return ResponseBuilder::json(true, $form, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(true, $form->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(true, $form->getErrors(), "WORK SCHEDULE EMPTY! ");
            }
            return ResponseBuilder::json(false, [], "MISSING PARAMS! ");
        }
        return ResponseBuilder::json(false, [], "METHOD ALLOW POST! ");
    }

    public function actionDelete()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id');
            if (!empty($id)) {
                $workSchedule = WorkSchedule::find()->where(['id' => $id, 'status' => WorkSchedule::STATUS_ACTIVE])->one();
                if (!empty($workSchedule)) {
                    $workSchedule->status = WorkSchedule::STATUS_DELETED;
                    $workSchedule->save(false);
                    return ResponseBuilder::json(true, $workSchedule, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, $workSchedule->getErrors(), "WORK SCHEDULE EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISSING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
    }
}