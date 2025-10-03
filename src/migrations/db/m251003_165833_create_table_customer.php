<?php

use yii\db\Migration;

class m251003_165833_create_table_customer extends Migration
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
        $this->createTable('{{%customer}}', [
            "id" => $this->primaryKey(),
            "name" => $this->string(),
            "code" => $this->string(),
            "phone" => $this->string(),
            "gender" => $this->integer(),
            "email" => $this->string(),
            "thumbnail" => $this->string(),
            "city" => $this->string(),
            "district" => $this->string(),
            "ward" => $this->string(),
            "address" => $this->string(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

        $this->createIndex("idx-customer-name", "customer", "name");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251003_165833_create_table_customer cannot be reverted.\n";

        return false;
    }
    */
}
