<?php

namespace app\modules\v1\admin\user\controllers;

use Yii;
use yii\base\Exception;
use yii\rest\Controller;
use app\models\UserToken;
use yii\web\HttpException;
use Random\RandomException;
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
     * @throws RandomException
     */
    public function actionForgetPassword()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $email = $request->post('email');
            if (!empty($email)) {
                $user = User::find()->where(['email' => $email, 'status' => User::STATUS_ACTIVE])->one();
                if (!empty($user)) {
                    $otp = random_int(100000, 999999);
                    $userToken = new UserToken();
                    $userToken->user_id = $user->id;
                    $userToken->type = "otp";
                    $userToken->token = $otp;
                    $userToken->expire_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));
                    if ($userToken->save(false)) {

                        $html = '
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin:auto; padding:20px; background:#f9f9f9;">
        <h2 style="text-align:center; color:#4CAF50; margin-bottom:10px;">
            OTP Change Password
        </h2>
        <p style="font-size:16px; color:#333;">
            Xin chào <strong>'.htmlspecialchars($user->username).'</strong>,
        </p>
        <p style="font-size:16px; color:#333;">
            Đây là mã OTP để đổi mật khẩu tài khoản của bạn. 
            Mã này chỉ có hiệu lực <strong>10 phút</strong> kể từ thời điểm gửi.
        </p>
        <div style="text-align:center; margin:30px 0;">
            <span style="
                display:inline-block;
                font-size:32px;
                letter-spacing:8px;
                color:#ffffff;
                background:#4CAF50;
                padding:12px 24px;
                border-radius:8px;
                font-weight:bold;
            ">'.$otp.'</span>
        </div>
        <p style="font-size:14px; color:#777;">
            Nếu bạn không yêu cầu đổi mật khẩu, vui lòng bỏ qua email này.
        </p>
        <hr style="border:none; border-top:1px solid #ddd; margin:30px 0;">
        <p style="font-size:12px; color:#aaa; text-align:center;">
            © '.date('Y').' Hung Store
        </p>
    </div>';
                        Yii::$app->mailer->compose()
                            ->setFrom([env('MAIL_USER') => 'Hung Store'])
                            ->setTo($user->email)
                            ->setSubject('OTP Change Password Admin Insight')
                            ->setHtmlBody($html)
                            ->send();

                        return ResponseBuilder::json(true, [], "CHECK MAIL TO GET OTP! ");
                    }
                    return ResponseBuilder::json(false, [], "VALIDATE FAIL! ");
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
    public function actionVerifyOtp()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $otp = $request->post('otp');
            if (!empty($otp)) {
                $userToken = UserToken::find()->where(['token' => $otp, 'type' => 'otp'])->one();
                if (!empty($userToken)) {
                    $now = time();
                    $expire = strtotime($userToken->expire_at);
                    if ($expire <= $now) {
                        return ResponseBuilder::json(false, null, "OTP EXPIRED!");
                    }
                    return ResponseBuilder::json(true, ['user_id' => $userToken->user_id], "Verify Success!");
                }
                return ResponseBuilder::json(false, null, "CUSTOMER EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
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
