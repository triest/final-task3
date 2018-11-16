<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_tag`.
 */
class m170124_021633_create_article_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('post_tag', [
            'id' => $this->primaryKey(),
            'post_id'=>$this->integer(),
            'tag_id'=>$this->integer()
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'tag_post_post_id',
            'post_tag',
            'post_id'
        );


        // add foreign key for table `user`
        $this->addForeignKey(
            'tag_post_post_id',
            'post_tag',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx_tag_id',
            'post_tag',
            'tag_id'
        );


        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-tag_id',
            'post_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_tag');
    }
}
