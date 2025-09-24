<?php

use yii\db\Migration;

class m250923_072123_create_table_shift extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shift}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'start_time' => $this->time(),
            'end_time' => $this->time(),
            'checkin_start' => $this->time(),
            'checkin_end' => $this->time(),
            'duration' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        $this->createIndex("idx-shift-name", "shift", "name");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shift}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250923_072123_create_table_shift cannot be reverted.\n";

        return false;
    }
    */
}
