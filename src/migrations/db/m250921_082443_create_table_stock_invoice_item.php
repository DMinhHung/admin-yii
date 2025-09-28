<?php

use yii\db\Migration;

class m250921_082443_create_table_stock_invoice_item extends Migration
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
        $this->createTable('{{%stock_invoice_item}}', [
            "id" => $this->primaryKey(),
            "invoice_id" => $this->string(),
            "product_variant_id" => $this->integer(),
            "warehouse_id" => $this->integer(),
            "quantity" => $this->integer(),
            "old_quantity" => $this->integer(),
            "price" => $this->double(),
            "total" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

        $this->createIndex("idx-stock_invoice_item-invoice_id", "stock_invoice_item", "invoice_id");
        $this->createIndex("idx-stock_invoice_item-product_variant_id", "stock_invoice_item", "product_variant_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_invoice}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250921_082443_create_table_stock_invoice_item cannot be reverted.\n";

        return false;
    }
    */
}
