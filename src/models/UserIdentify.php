<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use app\models\base\User;
use yii\web\IdentityInterface;
use yii\base\InvalidConfigException;

class UserIdentify extends User implements IdentityInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): UserToken|User|array|IdentityInterface|null
    {
        $accessToken = UserToken::find()->where(['token' => $token])->andWhere(['>', 'expire_at', strtotime('now')])->one();
        if (!$accessToken) return $accessToken;
        return self::findOne(['id' => $accessToken->user_id, 'status' => self::STATUS_ACTIVE]);
    }

    public function getId(): int|string
    {
        return $this->id;
    }

    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return void
     * Here is method create token of user to user_token table
     * @throws Exception
     */
    public function generateToken(): void
    {
        UserToken::generateAuthKey($this);
    }

    /**
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


    public function findByEmail($email): User|array|null
    {
        return static::find()
            ->andWhere(["email" => $email])
            ->one();
    }

    /**
     * Finds user by username or email
     *
     * @param string $login
     * @return User|array|null
     */
    public static function findByLogin(string $login): User|array|null
    {
        return static::find()
            ->andWhere(['or', ['username' => $login], ['email' => $login]])
            ->one();
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     *
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function setPassword(string $password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}