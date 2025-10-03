<?php

use yii\db\Migration;

class m251003_165855_create_table_new extends Migration
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
        $this->createTable('{{%new}}', [
            "id" => $this->primaryKey(),
            "title" => $this->string(),
            "slug" => $this->string(),
            "content" => $this->string(),
            "thumbnail" => $this->string(),
            "author" => $this->string(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%new}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251003_165855_create_table_new cannot be reverted.\n";

        return false;
    }
    */
}
