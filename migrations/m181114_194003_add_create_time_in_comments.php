<?php

use yii\db\Migration;

/**
 * Class m181114_194003_add_create_time_in_comments
 */
class m181114_194003_add_create_time_in_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comment', 'create_time', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181114_194003_add_create_time_in_comments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181114_194003_add_create_time_in_comments cannot be reverted.\n";

        return false;
    }
    */
}
