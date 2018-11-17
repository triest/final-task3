<?php

use yii\db\Migration;

/**
 * Class m181117_193131_add_columnt_for_confurm_mail
 */
class m181117_193131_add_columnt_for_confurm_mail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'emailConfurm', $this->integer()->defaultValue(0));
        $this->addColumn('user', 'emailToken', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'emailConfurm');
        $this->dropColumn('user', 'emailToken');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181117_193131_add_columnt_for_confurm_mail cannot be reverted.\n";

        return false;
    }
    */
}
