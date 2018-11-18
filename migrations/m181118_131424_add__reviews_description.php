<?php

use yii\db\Migration;

/**
 * Class m181118_131424_add__reviews_description
 */
class m181118_131424_add__reviews_description extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      //  $this->addColumn('user', 'emailConfurm', $this->integer()->defaultValue(0));
        $this->addColumn('reviews', 'description', $this->text(255)->defaultValue('')->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('reviews', 'description');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181118_131424_add__reviews_description cannot be reverted.\n";

        return false;
    }
    */
}
