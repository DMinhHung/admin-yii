<?php

namespace app\modules\v1\admin\user\controllers;

use Yii;
use yii\db\Exception;
use yii\rest\Controller;
use yii\web\HttpException;
use app\models\EmployeeUser;
use app\helpers\ResponseBuilder;

class EmployeeUserController extends Controller
{
    /**
     * @throws Exception
     * @throws HttpException
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $userId = $request->post('user_id');
            $employeeId = $request->post('employee_id');
            if (!empty($userId) && !empty($employeeId)) {
                $employeeUser = EmployeeUser::find()->where(['user_id' => $userId, 'employee_id' => $employeeId])->one();
                if (empty($employeeUser)) {
                    $employeeUser = new EmployeeUser();
                    $employeeUser->user_id = $userId;
                    $employeeUser->employee_id = $employeeId;
                    $employeeUser->save(false);
                    return ResponseBuilder::json(true, null, "CREATE SUCCESS! ");
                }
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
    }
}
