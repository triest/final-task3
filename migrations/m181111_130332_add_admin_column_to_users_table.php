<?php

use yii\db\Migration;

/**
 * Handles adding admin to table `users`.
 */
class m181111_130332_add_admin_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'isAdmin', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        $this->dropColumn('user', 'isAdmin');
    }
}
