<?php

use yii\db\Migration;

class m250920_045046_create_table_customer extends Migration
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
            "fb_url" => $this->string(),
            "thumbnail" => $this->string(),
            "city" => $this->string(),
            "district" => $this->string(),
            "ward" => $this->string(),
            "address" => $this->string(),
            "group_customer" => $this->integer(),
            "type" => $this->integer(),
            "tax_code" => $this->string(),
            "company_name" => $this->string(),
            "national" => $this->string(),
            "passport_number" => $this->string(),
            "bank_name" => $this->string(),
            "bank_account_number" => $this->string(),
            "current_debt" => $this->double(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

        $this->createIndex("idx-customer-group_customer", "customer", "group_customer");
        $this->createIndex("idx-customer-name", "customer", "name");
        $this->createIndex("idx-customer-name-type", "customer", ["name", "type"]);
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
        echo "m250920_045046_create_table_customer cannot be reverted.\n";

        return false;
    }
    */
}
