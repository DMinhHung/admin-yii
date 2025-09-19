<?php

use yii\db\Migration;

class m250911_032710_create_table_item extends Migration
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
        $this->createTable('{{%item}}', [
            "id" => $this->primaryKey(),
            "category_id" => $this->integer(),
            "brand_id" => $this->integer(),
            "name" => $this->string(),
            "slug" => $this->string(),
            "description" => $this->string(),
            "thumbnail" => $this->string(),
            "gallery" => $this->json(),
            "sku" => $this->string(),
            "barcode" => $this->string(),
            "price" => $this->double(),
            "cost" => $this->double(),
            "discount" => $this->string(),
            "stock" => $this->integer(),
            "weight" => $this->string(),
            "unit" => $this->string(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
        $this->createIndex("idx-item-category_id-brand_id", "item", ["category_id", "brand_id"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%item}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250911_032710_create_table_item cannot be reverted.\n";

        return false;
    }
    */
}
