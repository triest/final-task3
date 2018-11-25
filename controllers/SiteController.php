<?php
namespace app\controllers;

use app\models\Tag;
use app\models\Comment;
use app\models\CommentForm;
use app\models\City;
use app\models\Reviews;
//use Codeception\Step\Comment;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

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


    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

     //   return $this->render('index2');
       $ip=$this->getRealIpAddr();
     //  echo $ip;

     //   die();
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip=$_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        else $ip=$_SERVER['REMOTE_ADDR'];
     //   echo "<br>";
       // echo $ip;echo "<br>";

      //  echo Yii::$app->request->userIP;echo "<br>";

        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        if($query && $query['status'] == 'success') {
         //   echo 'My IP: '.$query['query'].', '.$query['isp'].', '.$query['org'].', '.$query ['country'].', '.$query['regionName'].', '.$query['city'].'!'."<br>";
        } else {
            echo 'Unable to get location';
        }

        $request = file_get_contents("http://api.sypexgeo.net/json/".$ip);
        $array = json_decode($request);
        //var_dump($array);
       // echo $array->city->name_ru;

        return $this->render('confirm_city',['city'=>$array->city->name_ru]);

    }



    public function actionView($id){
        $post = Post::findOne($id);
        $selectedTags=$post->getSelectedTags();
        $comments=$post->getArticleComments();
        $commentForm=new CommentForm();
        return $this->render('single',[
            'post'=>$post,
            'tags'=>$selectedTags,
            'comments'=>$comments,
            'commentForm'=>$commentForm
        ]);
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

    public function actionConfurm($city){
        $city2=City::find()->where(['name'=>$city])->one();
         //  echo $city2->name;
      //  die();

        $reviews=$city2->getReviews()->all();
     //   var_dump($reviews);


        return $this->render('reviews_to_city',['reviews'=>$reviews]);


    }

    public function actionDenide($city){
        echo $city;
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

    public function actionCreate()
    {
        $model = new Reviews();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $file=UploadedFile::getInstance($model,'img');

            $file=$model->uploadFile($file);

            return $this->actionConfurm($model->city);

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}