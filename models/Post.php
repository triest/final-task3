<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property int $status
 * @property int $author_id
 * @property int $article_id
 * @property string $create_time
 * @property string $update_time
 *
 * @property Comment[] $comments
 * @property User $author
 * @property PostTag[] $postTags
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['status', 'author_id', 'article_id'], 'integer'],
            [ [ 'status' ], 'in', 'range' => [ 1,2, 3 ] ],
            [['create_time', 'update_time'], 'date','format'=>'php:Y-m-d-h-mm-s'],
            [['create_time'],'default','value'=>date('Y-m-d')],
            [['title', 'content', 'tags'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'tags' => 'Tags',
            'status' => 'Status',
            'author_id' => 'Author ID',
            'article_id' => 'Article ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
{
    return $this->hasOne(User::className(), ['id' => 'author_id']);
}

    public function getAuthor2()
    {

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTag::className(), ['post_id' => 'id']);
    }

    public function getItems()
    {
        return $this->hasMany(\phpDocumentor\Reflection\DocBlock\Tag::className(), ['id' => 'tag_id'])
            ->viaTable('post_tag', ['post_id' => 'id']);
    }


    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('post_tag', ['post_id' => 'id']);
    }

    public function getTags2($id){


        $tags=null;
        return $tags;
    }

    public function getSelectedTags()
    {
        $selectedIds = $this->getTags()->select(['id','name'])/*->asArray()*/->all();
      //  var_dump($selectedIds);
      //  die();
        return ArrayHelper::getColumn($selectedIds, ['name']);
    }

    public function getSelectedComments()
    {
        $selectedIds = $this->getComments()->select(['id','content','status','post_id'])->where(['status'=>1])->all();
       //   var_dump($selectedIds);
     //     die();
        return $selectedIds;
       // return ArrayHelper::getColumn($selectedIds, ['id','content','status','post_id']);
    }


    public function getSelectedTags2()
    {
        $selectedIds = $this->getTags()->select('id','name')->all();
         //  var_dump($selectedIds);
        //  die();
        return$selectedIds;
    }

    public function saveTags($tags)
    {

        if (is_array($tags))
        {
            $this->clearCurrentTags();

            foreach($tags as $tag_id)
            {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function saveStatus($status)
    {
     $this->status=$status;
     return $this->save(false);

    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->create_time);
    }

    public static function getAll($pagination=5){
        // build a DB query to get all articles with status = 1
        $query = Post::find();

// get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

// create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count,'pageSize'=>$pagination]);

// limit the query using the pagination and retrieve the articles
       return $post = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        //var_dump($post);
    //    die();
        $date['post']=$post;
       // $date['pagination']=$pagination;
        return $date;
    }

    public function clearCurrentTags()
    {
        PostTag::deleteAll(['post_id'=>$this->id]);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id'=>'id']);
    }

    public function getArticleComments()
    {
        return $this->getComments()->where(['status'=>2])->all();
    }

    public function getPreview(){
      // $text_cut=$this->content;
        $text_cut=mb_substr($this->content, 0, 100);
        //var_dump($text_cut);
        return $text_cut;

    }

}
