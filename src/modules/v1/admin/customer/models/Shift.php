<?php

namespace app\modules\v1\admin\customer\models;

use app\models\base\Shift as BaseShift;

class Shift extends BaseShift
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = -99;
    public function fields()
    {
        return [
            'id',
            'name',
            'start_time',
            'end_time',
            'checkin_start',
            'checkin_end',
            'duration'
        ];
    }
}