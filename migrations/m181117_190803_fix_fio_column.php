<?php

use yii\db\Migration;

/**
 * Class m181117_190803_fix_fio_column
 */
class m181117_190803_fix_fio_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'fio', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('user', 'fio', $this->integer()->null());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181117_190803_fix_fio_column cannot be reverted.\n";

        return false;
    }
    */
}
