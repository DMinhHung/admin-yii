<?php

use yii\db\Migration;

class m250923_123955_create_table_employee extends Migration
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
        $this->createTable('{{%employee}}', [
            "id" => $this->primaryKey(),
            "username" => $this->string(),
            "full_name" => $this->string(),
            "email" => $this->string(),
            "phone" => $this->string(),
            "position" => $this->string(),
            "thumbnail" => $this->string(),
            "address" => $this->string(),
            "gender" => $this->integer(),
            "birthday" => $this->dateTime(),
            "start_date" => $this->dateTime(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

        $this->createIndex("idx-employee-username", "employee", "username");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%employee}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250923_123955_create_table_employee cannot be reverted.\n";

        return false;
    }
    */
}
