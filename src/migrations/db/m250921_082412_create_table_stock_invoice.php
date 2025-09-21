<?php

use yii\db\Migration;

class m250921_082412_create_table_stock_invoice extends Migration
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
        $this->createTable('{{%stock_invoice}}', [
            "id" => $this->primaryKey(),
            "code" => $this->string(),
            "type" => $this->integer(),
            "warehouse_id" => $this->integer(),
            "user_id" => $this->integer(),
            "note" => $this->text(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

        $this->createIndex("idx-stock_invoice-warehouse_id", "stock_invoice", "warehouse_id");
        $this->createIndex("idx-stock_invoice-user_id", "stock_invoice", "user_id");
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
        echo "m250921_082412_create_table_stock_invoice cannot be reverted.\n";

        return false;
    }
    */
}
