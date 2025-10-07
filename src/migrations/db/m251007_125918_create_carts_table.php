<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%carts}}`.
 */
class m251007_125918_create_carts_table extends Migration
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
        $this->createTable('{{%carts}}', [
            "id" => $this->primaryKey(),
            "customer_id" => $this->integer(),
            "session_id" => $this->string(),
            "status" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
        $this->createIndex("idx-carts-customer_id-status", "carts", ["customer_id", "status"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%carts}}');
    }
}
