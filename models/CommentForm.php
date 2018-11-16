<?php
namespace app\models;
use Yii;
use yii\base\Model;
class CommentForm extends Model
{
    public $comment;

    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'length' => [3,250]]

        ];
    }
    public function saveComment($article_id)
    {
        $comment = new Comment;
        $comment->content = $this->comment;
       // $comment->author = Yii::$app->user->id;
        $comment->post_id = $article_id;
        $comment->status = 1;
     //   $comment->create_time=Now();
     //   $comment->create_time = date('Y-m-d');
        return $comment->save();
    }
}