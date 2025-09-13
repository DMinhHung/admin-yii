<?php

use yii\db\Migration;

class m250911_032751_create_table_brand extends Migration
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
        $this->createTable('{{%brand}}', [
            "id" => $this->primaryKey(),
            "name" => $this->integer(),
            "slug" => $this->string(),
            "description" => $this->text(),
            "logo" => $this->string(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
        $this->createIndex("idx-brand-name", "brand", "name");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%brand}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250911_032751_create_table_brand cannot be reverted.\n";

        return false;
    }
    */
}
