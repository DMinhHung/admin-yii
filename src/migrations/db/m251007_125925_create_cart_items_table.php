<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart_items}}`.
 */
class m251007_125925_create_cart_items_table extends Migration
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
        $this->createTable('{{%cart_items}}', [
            "id" => $this->primaryKey(),
            "cart_id" => $this->string(),
            "item_id" => $this->string(),
            "quantity" => $this->integer(),
            "price" => $this->double(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
        $this->createIndex("idx-cart_items-cart_id", "cart_items", "cart_id");
        $this->createIndex("idx-cart_items-item_id", "cart_items", "item_id");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cart_items}}');
    }
}
