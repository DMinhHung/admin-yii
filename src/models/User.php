<?php

namespace app\models;

use \app\models\base\User as BaseUser;

/**
 * This is the model class for table "user".
 */
class User extends BaseUser
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
}
