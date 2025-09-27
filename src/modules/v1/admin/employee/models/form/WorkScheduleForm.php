<?php

namespace app\modules\v1\admin\employee\models\form;

use app\modules\v1\admin\employee\models\WorkSchedule;

class WorkScheduleForm extends WorkSchedule
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['employee_id', 'shift_id', 'work_date'], 'required'],
            [['employee_id', 'shift_id', 'copied_from'], 'integer'],
            [['repeat_weekly', 'apply_holiday'], 'boolean'],
            [['work_date', 'end_date'], 'safe'],
            [['repeat_days'], 'string'],
            [['employee_id', 'shift_id', 'work_date'], 'unique',
                'targetAttribute' => ['employee_id', 'shift_id', 'work_date'],
                'message' => 'Nhân viên này đã có lịch cho ca làm việc trong ngày này.'
            ],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ]);
    }

}