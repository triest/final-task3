<?php

use yii\db\Migration;

/**
 * Class m181105_101645_comment_true
 */
class m181105_101645_comment_true extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            //'title'=>$this->string()->notNull(),
            'content'=>$this->string()->notNull(),
            'tags'=>$this->string(),
            'status'=>$this->integer(),
          //  'author_id'=>$this->integer(),
            'post_id'=>$this->integer(),

        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-comment-post_id',
            'comment',
            'post_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-post_id',
            'comment',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181105_101645_comment_true cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181105_101645_comment_true cannot be reverted.\n";

        return false;
    }
    */
}
