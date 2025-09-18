<?php

use yii\db\Migration;

class m250917_123550_create_table_item_variant_attribute extends Migration
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
        $this->createTable('{{%item_variant_attribute}}', [
            "id" => $this->primaryKey(),
            "item_variant_id" => $this->integer(),
            "item_attribute_id" => $this->integer(),
            "item_attribute_value_id" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
        $this->createIndex("idx-item_variant_attribute-item_variant_id", "item_variant_attribute", "item_variant_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%item_variant_attribute}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250917_123550_create_table_item_variant_attribute cannot be reverted.\n";

        return false;
    }
    */
}
