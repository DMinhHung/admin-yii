<?php

use yii\db\Migration;

class m250920_045053_create_table_vendor extends Migration
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
        $this->createTable('{{%vendor}}', [
            "id" => $this->primaryKey(),
            "name" => $this->string(),
            "code" => $this->string(),
            "phone" => $this->string(),
            "email" => $this->string(),
            "city" => $this->string(),
            "district" => $this->string(),
            "ward" => $this->string(),
            "address" => $this->string(),
            "group_vendor" => $this->integer(),
            "type" => $this->integer(),
            "tax_code" => $this->string(),
            "company_name" => $this->string(),
            "current_debt" => $this->double(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vendor}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250920_045053_create_table_vendor cannot be reverted.\n";

        return false;
    }
    */
}
