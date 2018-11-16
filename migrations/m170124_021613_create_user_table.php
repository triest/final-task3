<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170124_021613_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(),
            'email'=>$this->string()->defaultValue(null),
            'password'=>$this->string(),
            'salt'=>$this->integer()->defaultValue(0),
            'profile'=>$this->string()->defaultValue(null)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
