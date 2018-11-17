<?php

use yii\db\Migration;

/**
 * Class m181117_193704_fix_fio_colomn2
 */
class m181117_193704_fix_fio_colomn2 extends Migration
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
        echo "m181117_193704_fix_fio_colomn2 cannot be reverted.\n";

        return false;
    }
    */
}
