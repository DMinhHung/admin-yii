<?php

namespace app\modules\v1\admin\customer\models;

use app\models\base\WorkSchedule as BaseWorkSchedule;

class WorkSchedule extends BaseWorkSchedule
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = -99;
    public function fields()
    {
        return [
            'id',
            'employee_id',
            'shift_id',
            'work_date',
            'repeat_weekly',
            'repeat_days',
            'end_date',
            'apply_holiday',
            'copied_from',
            'status'
        ];
    }

    public function getEmployee()
    {
        return $this->hasOne(Customer::class, ['id' => 'employee_id']);
    }

    public function getShift()
    {
        return $this->hasOne(Shift::class, ['id' => 'shift_id']);
    }

}