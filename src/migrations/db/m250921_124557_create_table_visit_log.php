<?php

use yii\db\Migration;

class m250921_124557_create_table_visit_log extends Migration
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
        $this->createTable('{{%visit_log}}', [
            "id" => $this->primaryKey(),
            "ip" => $this->string(),
            "agent" => $this->string(),
            "url" => $this->text(),
            "method" => $this->string(),
            "data" => $this->text(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%visit_log}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250921_124557_create_table_visit_log cannot be reverted.\n";

        return false;
    }
    */
}
