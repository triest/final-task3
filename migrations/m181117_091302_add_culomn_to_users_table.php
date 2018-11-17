<?php

use yii\db\Migration;

/**
 * Class m181117_091302_add_culomn_to_users_table
 */
class m181117_091302_add_culomn_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'fio', $this->integer()->defaultValue(null));
        $this->addColumn('user', 'phone', $this->string()->defaultValue(null));
        $this->addColumn('user', 'create_time',$this->dateTime()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'fio');
        $this->dropColumn('user', 'phone');
        $this->dropColumn('user', 'create_time');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181117_091302_add_culomn_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
