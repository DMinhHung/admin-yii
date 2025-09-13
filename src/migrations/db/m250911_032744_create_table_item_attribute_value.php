<?php

use yii\db\Migration;

class m250911_032744_create_table_item_attribute_value extends Migration
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
        $this->createTable('{{%item_attribute_value}}', [
            "id" => $this->primaryKey(),
            "attribute_id" => $this->integer(),
            "value" => $this->string(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
        $this->createIndex("idx-item_attribute_value-attribute_id", "item_attribute_value", "attribute_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%item_attribute_value}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250911_032744_create_table_item_attribute_value cannot be reverted.\n";

        return false;
    }
    */
}
