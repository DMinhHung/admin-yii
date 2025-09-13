<?php

use yii\db\Migration;

class m250911_032722_create_table_item_variant extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%item_variant}}', [
            "id" => $this->primaryKey(),
            "item_id" => $this->integer(),
            "sku" => $this->string(),
            "price" => $this->double(),
            "stock" => $this->integer(),
            "attributes" => $this->json(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
        $this->createIndex("idx-item_variant-item_id", "item_variant", "item_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%item_variant}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250911_032722_create_table_item_variant cannot be reverted.\n";

        return false;
    }
    */
}
