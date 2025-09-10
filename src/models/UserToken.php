<?php

namespace app\models;

use \app\models\base\UserToken as BaseUserToken;

/**
 * This is the model class for table "user_token".
 */
class UserToken extends BaseUserToken
{
    public $tokenExpiration = 60 * 24 * 365; // in seconds
    public $defaultAccessGiven = '{"access":["all"]}';
    public const TYPE_ACTIVATION = 'activation';
    public const TYPE_PASSWORD_RESET = 'password_reset';
    public const TYPE_LOGIN_PASS = 'login_pass';
    public const TOKEN_LENGTH = 40;
    public const TYPE_ADMIN_AUTHENTICATION_TOKEN = 'admin_authentication_token';
    public $defaultConsumer = 'web';
}
