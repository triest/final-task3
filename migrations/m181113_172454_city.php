<?php

use yii\db\Migration;

/**
 * Class m181113_172454_city
 */
class m181113_172454_city extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('city', [
            'id' => $this->primaryKey(),
            //'title'=>$this->string()->notNull(),
            'name'=>$this->string()->notNull(),
            'date_create'=>$this->dateTime(),


        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('city');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181113_172454_city cannot be reverted.\n";

        return false;
    }
    */
}
