<?php

use yii\db\Migration;

class m250911_032651_create_table_user_profile extends Migration
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
        $this->createTable('{{%user_profile}}', [
            "id" => $this->primaryKey(),
            "user_id" => $this->integer(),
            "firstname" => $this->string(),
            "lastname" => $this->string(),
            "gender" => $this->integer(),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ], $tableOptions);
        $this->createIndex("idx-user_profile-user_id", "user_profile", "user_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_profile}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250911_032651_create_table_user_profile cannot be reverted.\n";

        return false;
    }
    */
}
