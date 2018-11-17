<?php

use yii\db\Migration;

/**
 * Class m181113_174208_reviews
 */
class m181113_174208_reviews extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reviews', [
            'id' => $this->primaryKey(),
            'id_city'=>$this->integer()->notNull(),
            'title'=>$this->text()->notNull(),
            'rating'=>$this->integer(),
             'img'=>$this->string(),
             'id_autor'=>$this->integer(),
            'date_create'=>$this->dateTime('Y-m-d H:i:s'),
        ]);

        // creates index for column `id_city`
        $this->createIndex(
            'idx-reviews-id_city',
            'reviews',
            'id_city'
        );
        // add foreign key for table `city`
        $this->addForeignKey(
            'fk-city-id_city',
            'reviews',
            'id_city',
            'city',
            'id',
            'CASCADE'
        );

        // creates index for column `id_city`
        $this->createIndex(
            'idx-reviews-id_author',
            'reviews',
            'id_autor'
        );
        // add foreign key for table `city`
        $this->addForeignKey(
            'fk-city-id_autor',
            'reviews',
            'id_autor',
            'users',
            'id',
            'CASCADE'
        );
    }



    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181113_174208_reviews cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }
*/
    public function down()
    {
        $this->dropTable('reviews');

        return false;
    }

}
