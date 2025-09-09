<?php

use yii\db\Migration;

class m250909_130330_create_table_user extends Migration
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
        $this->createTable('{{%user}}', [
            "id" => $this->primaryKey(),
            "access_token" => $this->string(),
            "token" => $this->string(),
            "auth_key" => $this->string(),
            "email" => $this->string(),
            "username" => $this->string(),
            "oauth_client" => $this->string(),
            "oauth_client_user_id" => $this->string(),
            "status" => $this->integer(),
            "is_verify" => $this->boolean()->defaultValue(0),
            "password_hash" => $this->string(),
            "logged_at" => $this->dateTime(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250909_130330_create_table_user cannot be reverted.\n";

        return false;
    }
    */
}
