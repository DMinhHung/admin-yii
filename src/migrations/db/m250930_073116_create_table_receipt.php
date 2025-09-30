<?php

use yii\db\Migration;

class m250930_073116_create_table_receipt extends Migration
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
        $this->createTable('{{%receipt}}', [
            "id" => $this->primaryKey(),
            "receipt_no" => $this->string(),
            "date" => $this->dateTime(),
            "email" => $this->string(),
            "payer_name" => $this->string(),
            "payer_phone" => $this->string(),
            "reason" => $this->text(),
            "amount" => $this->double(),
            "payment_method" => $this->integer(),
            "invoice_id" => $this->integer(),
            "start_date" => $this->integer(),
            "created_by" => $this->integer(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

        $this->createIndex("idx-receipt-receipt_no", "receipt", "receipt_no");
        $this->createIndex("idx-receipt-payer_name", "receipt", "payer_name");
        $this->createIndex("idx-receipt-payment_method", "receipt", "payment_method");
        $this->createIndex("idx-receipt-invoice_id", "receipt", "invoice_id");
        $this->createIndex("idx-receipt-created_by", "receipt", "created_by");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%receipt}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250930_073116_create_table_receipt cannot be reverted.\n";

        return false;
    }
    */
}
