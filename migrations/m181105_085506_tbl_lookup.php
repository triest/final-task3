<?php

use yii\db\Migration;

/**
 * Class m181105_085506_tbl_lookup
 */
class m181105_085506_tbl_lookup extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lookup', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'type'=>$this->string(),
            'position'=>$this->integer(),


        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181105_085506_tbl_lookup cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181105_085506_tbl_lookup cannot be reverted.\n";

        return false;
    }
    */
}
