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
use app\modules\v1\admin\user\models\form\UserLoginForm;
use app\modules\v1\admin\user\models\form\UserProfileForm;

class FormController extends Controller
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
    public function actionLogin()
    {
        $user = new UserLoginForm();
        $user->load(Yii::$app->request->post());
        $userLogged = $user->login();
        if ($user->hasErrors() || !$user->validate()) {
            return ResponseBuilder::json(false, ["errors" => $user->getErrors()], "Can't login");
        }
        $user = $userLogged;
        $user->logged_at = date("Y-m-d H:i:s");
        $user->save(false);
        return ResponseBuilder::json(true, ["user" => $user], "Login Successfully");
    }

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
            if ($user->validate() && $user->save()) {
                $userProfile = new UserProfileForm(["user_id" => $user->id]);
                $userProfile->load(Yii::$app->request->post());
                if ($userProfile->validate() && $userProfile->save()) {
                    $transaction->commit();
                    return ResponseBuilder::json(true, ["user" => $user], "Create User successfully");
                }
                $transaction->rollBack();
                return ResponseBuilder::json(false, ["errors" => $userProfile->getErrors()], "Can't Create User Profile");
            }
            $transaction->rollBack();
            return ResponseBuilder::json(false, ["errors" => $user->getErrors()], "Can't Create User");
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
    public function actionUpdate($id)
    {
        $user = UserForm::findOne($id);
        $userProfile = UserProfileForm::find()->where(["user_id" => $id])->one();
        if (!empty($user) && !empty($userProfile)) {
            $user->load(Yii::$app->request->post());
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($user->validate() && $user->save()) {
                    $userProfile->load(Yii::$app->request->post());
                    if ($userProfile->validate() && $userProfile->save()) {
                        $transaction->commit();
                        return ResponseBuilder::json(true, ["user" => $user], "Update User successfully");
                    }
                    $transaction->rollBack();
                    return ResponseBuilder::json(false, ["errors" => $userProfile->getErrors()], "Validate user profile fail! ");
                }
                $transaction->rollBack();
                return ResponseBuilder::json(false, ["errors" => $user->getErrors()], "Validate user fail! ");
            } catch (\Exception $exception) {
                $transaction->rollBack();
                return ResponseBuilder::json(false, ["errors" => $user->getErrors()], "Can't Update User");
            }
        }
        return ResponseBuilder::json(false, null, "User Not Found! ");
    }

    /**
     * @throws NotFoundHttpException
     * @throws HttpException
     * @throws \yii\db\Exception
     */
    public function actionDelete(int $id)
    {
        $user = UserForm::find()->where(['id' => $id])->one();
        if (!empty($user)) {
            $user->status = UserForm::STATUS_DELETED;
            if ($user->save()) {
                return ResponseBuilder::json(true, [], "Delete user successfully");
            }
            return ResponseBuilder::json(false, [], "User delete fail! ");
        }
        return ResponseBuilder::json(false, [], "User not found! ");
    }

    /**
     * @throws NotFoundHttpException
     * @throws HttpException
     */
    public function actionView(int $id)
    {
        $user = User::find()->where(['id' => $id])->one();
        if (!empty($user)) {
            return ResponseBuilder::json(true, ["user" => $user]);
        }
        return ResponseBuilder::json(false, null, "User not found! ");
    }

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
