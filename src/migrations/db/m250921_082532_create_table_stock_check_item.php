<?php

use yii\db\Migration;

class m250921_082532_create_table_stock_check_item extends Migration
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
        $this->createTable('{{%stock_check_item}}', [
            "id" => $this->primaryKey(),
            "check_id" => $this->string(),
            "product_id" => $this->integer(),
            "actual_quantity" => $this->integer(),
            "system_quantity" => $this->integer(),
            "difference_quantity" => $this->integer(),
            "note" => $this->string(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

        $this->createIndex("idx-stock_check_item-check_id", "stock_check_item", "check_id");
        $this->createIndex("idx-stock_check_item-product_id", "stock_check_item", "product_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_check_item}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250921_082532_create_table_stock_check_item cannot be reverted.\n";

        return false;
    }
    */
}
