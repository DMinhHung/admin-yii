<?php

namespace app\modules\v1\admin\customer\controllers;

use Yii;
use app\modules\v1\admin\customer\models\form\ShiftForm;
use yii\rest\Controller;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\customer\models\Shift;
use app\modules\v1\admin\customer\models\search\ShiftSearch;

class ShiftController extends Controller
{
    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new ShiftSearch())->search(Yii::$app->request->queryParams));
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $form = new ShiftForm();
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
                $form = ShiftForm::find()->where(['id' => $id, 'status' => Shift::STATUS_ACTIVE])->one();
                if (!empty($form)) {
                    $form->load($request->post());
                    if ($form->validate() && $form->save()) {
                        return ResponseBuilder::json(true, $form, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(true, $form->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(true, $form->getErrors(), "SHIFT EMPTY! ");
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
                $workSchedule = Shift::find()->where(['id' => $id, 'status' => Shift::STATUS_ACTIVE])->one();
                if (!empty($workSchedule)) {
                    $workSchedule->status = Shift::STATUS_DELETED;
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
