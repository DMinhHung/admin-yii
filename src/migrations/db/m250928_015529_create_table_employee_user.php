<?php

use yii\db\Migration;

class m250928_015529_create_table_employee_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%employee_user}}', [
            "id" => $this->primaryKey(),
            "user_id" => $this->integer(),
            "employee_id" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

        $this->createIndex("idx-employee-user_id-employee_id", "employee_user", ["user_id", "employee_id"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%employee_user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250928_015529_create_table_employee_user cannot be reverted.\n";

        return false;
    }
    */
}
