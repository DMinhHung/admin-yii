<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 * @method User[] all($db = null)
 * @method User one($db = null)
 */
class UserQuery extends \yii\db\ActiveQuery
{
    public function notDelete()
    {
        return $this->andWhere(["<>", "user.status", User::STATUS_DELETED]);
    }

}
