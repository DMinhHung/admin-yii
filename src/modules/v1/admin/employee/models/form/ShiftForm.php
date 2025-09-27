<?php

namespace app\modules\v1\admin\employee\models\form;

use app\modules\v1\admin\employee\models\Shift;

class ShiftForm extends Shift
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'start_time', 'end_time'], 'required'],

            [['start_time', 'end_time', 'checkin_start', 'checkin_end'], 'safe'],
            [['duration'], 'number'],
            [['name'], 'string', 'max' => 100],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ]);
    }

}