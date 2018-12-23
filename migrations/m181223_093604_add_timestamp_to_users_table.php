<?php

use yii\db\Migration;

/**
 * Class m181223_093604_add_timestamp_to_users_table
 */
class m181223_093604_add_timestamp_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'create_time', 'timestamp');//timestamp new_data_type
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
     //   echo "m181223_093604_add_timestamp_to_users_table cannot be reverted.\n";
        $this->alterColumn('user', 'create_time', 'date');//timestamp new_data_type
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181223_093604_add_timestamp_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
