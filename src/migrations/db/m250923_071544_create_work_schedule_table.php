<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%work_schedule}}`.
 */
class m250923_071544_create_work_schedule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%work_schedule}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer(),
            'shift_id' => $this->integer(),
            'work_date' => $this->date(),
            'repeat_weekly' => $this->integer(),
            'repeat_days' => $this->text(),
            'end_date' => $this->date(),
            'apply_holiday' => $this->integer(),
            'copied_from' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        $this->createIndex("idx-work_schedule-employee_id-shift_id", "work_schedule", ["employee_id", "shift_id"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%work_schedule}}');
    }
}
