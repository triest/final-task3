<?php
namespace app\controllers;
use app\models\Post;
use app\models\Tag;
use app\models\Comment;
use app\models\CommentForm;
//use Codeception\Step\Comment;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // $data=Post::find();
        $query = Post::find()->where(['status'=>2]);
        $countQuery = clone $query;
        $count=$query->count();
        //   $query = Post::find();
        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();
        $pageSize=10;
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $commentForm = new CommentForm();
        //die();
        return $this->render('index',
            [
                'post'=>$posts,
                'pagination'=>$pagination,
                'commentForm'=>$commentForm
            ]);
    }



    public function actionView($id){
        $post = Post::findOne($id);
        $tags=$post->tags;
        //  var_dump($tags);
        //  die();
        $selectedTags=$post->getSelectedTags();
        // $comments=$post->comments;
        $comments=$post->getArticleComments();

        //  var_dump($comments);
        $commentForm=new CommentForm();
        //  var_dump($selectedTags);
        //   die();
        return $this->render('single',[
            'post'=>$post,
            'tags'=>$selectedTags,
            'comments'=>$comments,
            'commentForm'=>$commentForm
        ]);
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionTag($tag){
        // var_dump($tag);
        $tags2=Tag::find()
            ->where(['name'=>$tag])
            ->one();
        //   $tags2=Tag::find()->where(['name'=>$tag])->andWhere(['status'=>2])->one();
        //  var_dump($tags2);
        $posts=$tags2->getPosts()->select(['id','title','create_time'])
            ->where(['status'=>2])
            ->all();
        $count = 10;
        // var_dump($posts);
        $pageSize=10;
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);
        //die();
        return $this->render('index',
            [
                'post'=>$posts,
                'pagination'=>$pagination,
            ]);
    }
    public function  actionComment($id){
        //die($id);
        $model = new CommentForm();
        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            if($model->saveComment($id))
            {
                Yii::$app->getSession()->setFlash('comment', 'Your comment will be added soon!');
                return $this->redirect(['site/view','id'=>$id]);
            }
        }
    }
    public function getPoluparTags(){
        //   return 'hello word';
        $tags=Tag::find()->limit(10)->all();
        return $tags;
    }
    public function getLastComments(){

        $comments=Comment::find()->where(['status'=>2])->orderBy('create_time','ASC')->limit(5)->all();
        //  var_dump($comments);
        return $comments;
    }
}