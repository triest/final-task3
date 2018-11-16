<?php

use yii\db\Migration;

/**
 * Class m181114_204008_add_author_to_comments
 */
class m181114_204008_add_author_to_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comment', 'author', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('comment', 'author');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181114_204008_add_author_to_comments cannot be reverted.\n";

        return false;
    }
    */
}
