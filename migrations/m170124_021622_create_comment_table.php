<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m170124_021622_create_comment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title'=>$this->string()->notNull(),
            'content'=>$this->string()->notNull(),
            'tags'=>$this->string(),
            'status'=>$this->integer(),
            'author_id'=>$this->integer(),
            'article_id'=>$this->integer(),
            'create_time'=>$this->dateTime(),
            'update_time'=>$this->dateTime()

        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-post-author_id',
            'post',
            'author_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-author_id',
            'post',
            'author_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `article_id`
   /*     $this->createIndex(
            'idx-article_id',
            'comment',
            'article_id'
        );

        // add foreign key for table `article`
        $this->addForeignKey(
            'fk-article_id',
            'comment',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );*/
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('post');
    }
}
