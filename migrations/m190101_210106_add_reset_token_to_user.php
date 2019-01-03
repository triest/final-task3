<?php

use yii\db\Migration;

/**
 * Class m190101_210106_add_reset_token_to_user
 */
class m190101_210106_add_reset_token_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'resetToken', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'resetToken');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190101_210106_add_reset_token_to_user cannot be reverted.\n";

        return false;
    }
    */
}
