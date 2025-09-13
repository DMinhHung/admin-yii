<?php

namespace app\modules\v1\admin\user\models\form;

use yii\base\Exception;
use app\modules\v1\admin\user\models\User;

class UserLoginForm extends User
{
    public $password;

    public function rules()
    {
        return ([
            ["email", "required"],
            ["password", "required"]
        ]);
    }

    /**
     * @throws Exception
     */
    public function login()
    {
        $user = User::findByLogin($this->email);
        if (!$user) {
            $this->addError("email", "Email or Username user not found");
            return false;
        }
        if (!$user->validatePassword($this->password)) {
            $this->addError("password", "Account Invalid");
            return false;
        }
        $user->generateToken();
        return $user;
    }

}