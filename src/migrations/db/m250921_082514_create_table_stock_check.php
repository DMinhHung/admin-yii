<?php

use yii\db\Migration;

class m250921_082514_create_table_stock_check extends Migration
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
        $this->createTable('{{%stock_check}}', [
            "id" => $this->primaryKey(),
            "code" => $this->string(),
            "warehouse_id" => $this->integer(),
            "user_id" => $this->integer(),
            "note" => $this->text(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

        $this->createIndex("idx-stock_check-warehouse_id", "stock_check", "warehouse_id");
        $this->createIndex("idx-stock_check-user_id", "stock_check", "user_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_check}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250921_082514_create_table_stock_check cannot be reverted.\n";

        return false;
    }
    */
}
