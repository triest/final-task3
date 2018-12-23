<?php

use yii\db\Migration;

/**
 * Class m181113_175913_user
 */
class m181113_175913_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('user', 'fio', $this->integer()->defaultValue(null));
        $this->addColumn('user', 'phone', $this->string()->defaultValue(null));
        $this->addColumn('user', 'create_time',$this->timestamp()->defaultValue(null));
    }




    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      //  $this->dropTable('user');
        $this->dropColumn('user', 'fio');
        $this->dropColumn('user', 'phone');
        $this->dropColumn('user', 'create_time');
    }

  
}
