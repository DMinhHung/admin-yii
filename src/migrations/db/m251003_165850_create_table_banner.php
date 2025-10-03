<?php

use yii\db\Migration;

class m251003_165850_create_table_banner extends Migration
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
        $this->createTable('{{%banner}}', [
            "id" => $this->primaryKey(),
            "title" => $this->string(),
            "image" => $this->string(),
            "link" => $this->string(),
            "status" => $this->integer(),
            "sort_order" => $this->integer()->defaultValue(0),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%banner}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251003_165850_create_table_banner cannot be reverted.\n";

        return false;
    }
    */
}
