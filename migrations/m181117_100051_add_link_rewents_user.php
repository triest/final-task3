<?php

use yii\db\Migration;

/**
 * Class m181117_100051_add_link_rewents_user
 */
class m181117_100051_add_link_rewents_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        // add foreign key for table `city`
        $this->addForeignKey(
            'fk-city-id_autor',
            'reviews',
            'id_autor',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181117_100051_add_link_rewents_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181117_100051_add_link_rewents_user cannot be reverted.\n";

        return false;
    }
    */
}