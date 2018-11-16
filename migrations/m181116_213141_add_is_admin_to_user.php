<?php

use yii\db\Migration;

/**
 * Class m181116_213141_add_is_admin_to_user
 */
class m181116_213141_add_is_admin_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181116_213141_add_is_admin_to_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181116_213141_add_is_admin_to_user cannot be reverted.\n";

        return false;
    }
    */
}
