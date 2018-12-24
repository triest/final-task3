<?php

use yii\db\Migration;

/**
 * Class m181224_205131_add_timestamp_to_reviews_table
 */
class m181224_205131_add_timestamp_to_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('reviews', 'date_create', 'timestamp');//timestamp new_data_type

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('reviews', 'timestamp', 'date_create');//timestamp new_data_type

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181224_205131_add_timestamp_to_reviews_table cannot be reverted.\n";

        return false;
    }
    */
}
