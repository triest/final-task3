<?php

use yii\db\Migration;

/**
 * Class m181222_153542_rename_column_city_id
 */
class m181222_153542_rename_column_city_id extends Migration
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
        echo "m181222_153542_rename_column_city_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181222_153542_rename_column_city_id cannot be reverted.\n";

        return false;
    }
    */
}
