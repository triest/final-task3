<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $content

 * @property int $status
 * @property int $post_id
 *
 * @property Post $post
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['status', 'post_id'], 'integer'],
            [['content'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['create_time'], 'date','format'=>'php:Y-m-d-h-mm-s'],
            [['create_time'],'default','value'=>date('Y-m-d-h-mm-s')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
           // 'tags' => 'Tags',
            'status' => 'Status',
            'post_id' => 'Post ID',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public function saveStatus($status)
    {
      //  var_dump($status);
      //  die();
        $this->status=$status;
        return $this->save(false);

    }
}
