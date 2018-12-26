<?php

use yii\db\Migration;

/**
 * Class m181226_193143_drop_id_city_in_reviews
 */
class m181226_193143_drop_id_city_in_reviews extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('reviews', 'id_city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('reviews', 'id_city', $this->integer());

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181226_193143_drop_id_city_in_reviews cannot be reverted.\n";

        return false;
    }
    */
}
