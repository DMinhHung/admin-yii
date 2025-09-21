<?php

use yii\db\Migration;

class m250921_080323_update_table_user_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_profile', 'code', $this->string()->after("gender"));
        $this->addColumn('user_profile', 'thumbnail', $this->string()->after("code"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("user_profile", "thumbnail");
        $this->dropColumn("user_profile", "code");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250921_080323_update_table_user_profile cannot be reverted.\n";

        return false;
    }
    */
}
