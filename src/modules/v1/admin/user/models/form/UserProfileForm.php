<?php

namespace app\modules\v1\admin\user\models\form;

use app\models\UserProfile;

class UserProfileForm extends UserProfile
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ["gender", "in", "range" => [self::GENDER_FEMALE, self::GENDER_MALE, self::GENDER_UNDEFINED]]
        ]);
    }
}