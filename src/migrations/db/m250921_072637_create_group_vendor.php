<?php

use yii\db\Migration;

class m250921_072637_create_group_vendor extends Migration
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
        $this->createTable('{{%group_vendor}}', [
            "id" => $this->primaryKey(),
            "name" => $this->string(),
            "value" => $this->text(),
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
        $this->dropTable('{{%group_vendor}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250921_072637_create_group_vendor cannot be reverted.\n";

        return false;
    }
    */
}
