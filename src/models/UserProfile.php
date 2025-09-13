<?php

namespace app\models;

use \app\models\base\UserProfile as BaseUserProfile;

/**
 * This is the model class for table "user_profile".
 */
class UserProfile extends BaseUserProfile
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 0;
    const GENDER_UNDEFINED = 2;

    public function formName()
    {
        return "";
    }
}
