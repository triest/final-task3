<?php

use yii\db\Migration;

/**
 * Class m181226_190717_dropReviewsForeginKey
 */
class m181226_190717_dropReviewsForeginKey extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this-> dropForeignKey('fk-city-id_city','reviews');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181226_190717_dropReviewsForeginKey cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181226_190717_dropReviewsForeginKey cannot be reverted.\n";

        return false;
    }
    */
}
