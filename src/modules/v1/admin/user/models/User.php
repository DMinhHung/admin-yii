<?php

namespace app\modules\v1\admin\user\models;

use app\models\User as BaseUser;

class User extends BaseUser
{

    public function fields()
    {
        return [
            "id",
            "email",
            "username",
            "token",
            "logged_at",
            "created_at",
            "updated_at",
            "status",
            "role" => function () {
                return current(array_map(function ($item) {
                    return $item->item_name;
                }, $this->authAssignment));
            },
            'phone',
//            "profile" => "profile",
        ];
    }
}