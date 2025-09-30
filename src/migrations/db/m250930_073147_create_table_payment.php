<?php

use yii\db\Migration;

class m250930_073147_create_table_payment extends Migration
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
        $this->createTable('{{%payment}}', [
            "id" => $this->primaryKey(),
            "payment_no" => $this->string(),
            "date" => $this->dateTime(),
            "payee_name" => $this->string(),
            "payee_phone" => $this->string(),
            "reason" => $this->text(),
            "amount" => $this->double(),
            "payment_method" => $this->integer(),
            "invoice_id" => $this->integer(),
            "created_by" => $this->integer(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

        $this->createIndex("idx-receipt-payment_no", "payment", "payment_no");
        $this->createIndex("idx-receipt-payee_name", "payment", "payee_name");
        $this->createIndex("idx-receipt-payment_method", "payment", "payment_method");
        $this->createIndex("idx-receipt-invoice_id", "payment", "invoice_id");
        $this->createIndex("idx-receipt-created_by", "payment", "created_by");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250930_073147_create_table_payment cannot be reverted.\n";

        return false;
    }
    */
}
