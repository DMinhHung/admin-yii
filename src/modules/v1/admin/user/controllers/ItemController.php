<?php

namespace app\modules\v1\admin\user\controllers;

use Yii;
use yii\base\Exception;
use yii\rest\Controller;
use yii\web\HttpException;
use app\helpers\ResponseBuilder;
use app\models\User as UserAlias;
use yii\web\NotFoundHttpException;
use app\modules\v1\admin\user\models\User;
use app\modules\v1\admin\user\models\form\UserForm;
use app\modules\v1\admin\user\models\search\UserSearch;
//use app\modules\v1\admin\user\models\search\UserSearch;
//use app\modules\v1\admin\user\models\form\UserLoginForm;
//use app\modules\v1\admin\user\models\form\UserProfileForm;

class ItemController extends Controller
{

    public function verbs()
    {
        return array_merge(parent::verbs(), [
            "login" => ["POST"],
            "create" => ["POST"],
            "update" => ["POST"],
            "index" => ["GET"]
        ]);
    }

    /**
     * @throws HttpException
     * @throws Exception
     */
//    public function actionLogin()
//    {
//        $user = new UserLoginForm();
//        $user->load(Yii::$app->request->post());
//        $userLogged = $user->login();
//        if ($user->hasErrors() || !$user->validate()) {
//            return ResponseBuilder::json(false, ["errors" => $user->getErrors()], "Can't login");
//        }
//        $user = $userLogged;
//        $user->logged_at = date("Y-m-d H:i:s");
//        $user->save(false);
//        return ResponseBuilder::json(true, ["user" => $user], "Login Successfully");
//    }

    /**
     * @throws HttpException
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $user = new UserForm();
        $user->setScenario(UserAlias::SCENARIO_CREATE);
        $user->load(Yii::$app->request->post());
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$user->validate() || !$user->save()) {
                $transaction->rollBack();
                return ResponseBuilder::json(false, ["errors" => $user->getErrors()], "Can't Create User");
            }
//            $userProfile = new UserProfileForm([
//                "user_id" => $user->id
//            ]);
//            $userProfile->load(Yii::$app->request->post());
//            if (!$userProfile->validate() || !$userProfile->save()) {
//                $transaction->rollBack();
//                return ResponseBuilder::json(false, ["errors" => $userProfile->getErrors()], "Can't Create User Profile");
//            }

            return ResponseBuilder::json(true, ["user" => $user], "Create User successfully");
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }

    /**
     * @throws NotFoundHttpException
     * @throws HttpException
     * @throws \yii\db\Exception
     */
//    public function actionUpdate($id)
//    {
//        $user = UserForm::findOne($id);
////        $userProfile = UserProfileForm::find()->where(["user_id" => $id])->one();
////        $tenantIds = Yii::$app->request->post('tenant_ids', []);
//        if (!$user || !$userProfile) {
//            throw new NotFoundHttpException("User not found");
//        }
//        $user->load(Yii::$app->request->post());
//        $transaction = Yii::$app->db->beginTransaction();
//        try {
//            if (!$user->validate() || !$user->save()) {
//                $transaction->rollBack();
//                return ResponseBuilder::json(false, ["errors" => $user->getErrors()], "Can't Update User");
//            }
//            $userProfile->load(Yii::$app->request->post());
//            if (!$userProfile->validate() || !$userProfile->save()) {
//                $transaction->rollBack();
//                return ResponseBuilder::json(false, ["errors" => $userProfile->getErrors()], "Can't Update User Profile");
//            }
//            if ($tenantIds) {
//                $old = TenantUser::find()->where(["user_id" => $user->id])->all();
//                $oldTenantIds = array_column($old, "tenant_id");
//                $newTenantIds = $tenantIds;
//                $listAdd = array_diff($newTenantIds, $oldTenantIds);
//                $listRemove = array_diff($oldTenantIds, $newTenantIds);
//                foreach ($listAdd as $tenantId) {
//                    $tenantUser = new TenantUser();
//                    $tenantUser->tenant_id = $tenantId;
//                    $tenantUser->user_id = $user->id;
//                    $tenantUser->save(false);
//                }
//                TenantUser::deleteAll(["user_id" => $user->id, 'tenant_id' => $listRemove]);
//            } else {
//                TenantUser::deleteAll(["user_id" => $user->id]);
//            }
//            $transaction->commit();
//            return ResponseBuilder::json(true, ["user" => $user], "Update User successfully");
//        } catch (\Exception $exception) {
//            $transaction->rollBack();
//            throw $exception;
//        }
//    }

//    /**
//     * @throws NotFoundHttpException
//     * @throws HttpException
//     */
//    public function actionDelete(int $id)
//    {
//        $user = UserForm::findOne($id);
//        if (!$user) {
//            throw new NotFoundHttpException("User not found");
//        }
//        $user->status = UserForm::STATUS_DELETED;
//        if ($user->save()) {
//            return ResponseBuilder::json(true, [], "Delete user successfully");
//        }
//        return ResponseBuilder::json(false, [], "Can't Delete user");
//    }
//
//    /**
//     * @throws NotFoundHttpException
//     * @throws HttpException
//     */
//    public function actionView(int $id)
//    {
//        $user = User::findOne($id);
//        if (!$user) {
//            throw new NotFoundHttpException("user not found");
//        }
//        return ResponseBuilder::json(true, ["user" => $user]);
//    }

    /**
     * @throws HttpException
     */
    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new UserSearch())->search(Yii::$app->request->queryParams));
    }

    /**
     * @throws HttpException
     */
    public function actionMe()
    {
        return ResponseBuilder::json(true, ["user" => User::findOne(Yii::$app->user->getId())]);
    }
}
