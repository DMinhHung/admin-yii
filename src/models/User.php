<?php

namespace app\models;

/**
 * This is the model class for table "user".
 */
class User extends UserIdentify
{
    const ID_DEFAULT_ADMIN = 1;
    const ROLE_ADMIN = "admin";
    const ROLE_MANAGER = "manager";
    const ROLE_USER = "user";
    const ROLE_APPLICATION = "application";
    const SCENARIO_CREATE = "create";
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }

    public function getAuthAssignment()
    {
        return $this->hasMany(AuthAssignment::className(), ["user_id" => "id"]);
    }

    public function getProfile()
    {
        return $this->hasOne(UserProfile::class, ["user_id" => "id"]);
    }
}
