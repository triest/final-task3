<?php

use yii\db\Migration;

/**
 * Handles the creation of table `city_review`.
 */
class m181222_141616_create_city_review_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('city_review', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer(),
            'review_id' => $this->integer()
        ]);
        // creates index for column `user_id`
        $this->createIndex(
            'idx_city_id',
            'city_review',
            'city_id'
        );
        // add foreign key for table `user`
        $this->addForeignKey(
            'review_city_city_id',
            'city_review',
            'city_id',
            'city',
            'id',
            'CASCADE'
        );
        // creates index for column `user_id`
        $this->createIndex(
            'idx_review_id',
            'city_review',
            'review_id'
        );
        // add foreign key for table `user`
        $this->addForeignKey(
            'review_review_review_id',
            'city_review',
            'review_id',
            'reviews',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('city_review');
    }
}
