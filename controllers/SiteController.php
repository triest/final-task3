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
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
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

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
        if ($query && $query['status'] == 'success') {
            //   echo 'My IP: '.$query['query'].', '.$query['isp'].', '.$query['org'].', '.$query ['country'].', '.$query['regionName'].', '.$query['city'].'!'."<br>";
        } else {
            echo 'Unable to get location';
        }

        $request = file_get_contents("http://api.sypexgeo.net/json/" . $ip);
        $array = json_decode($request);
        //var_dump($array);
        // echo $array->city->name_ru;

        return $this->render('confirm_city', ['city' => $array->city->name_ru]);

    }


    public function actionView($id)
    {
        $post = Post::findOne($id);
        $selectedTags = $post->getSelectedTags();
        $comments = $post->getArticleComments();
        $commentForm = new CommentForm();
        return $this->render('single', [
            'post' => $post,
            'tags' => $selectedTags,
            'comments' => $comments,
            'commentForm' => $commentForm
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
            'model' => $model
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


    public function actionConfurm($city)
    {
        $city2 = City::find()->where(['name' => $city])->one();
        $reviews = $city2->getReviews()->all();
        return $this->render('test', ['reviews' => $reviews]);
    }

    public function actionDenide($city)
    {
        //  echo $city;
        $cityes = City::find()->all();
        //   echo '<br>';
        //  var_dump($cityes);
        foreach ($cityes as $city) {
            echo $city->name;
            echo '<br>';
        }
        $reciews = Reviews::find()->all();
        $city=Reviews::find()->select('city_id')->distinct();
        var_dump($city);

        $count=0;
        foreach ($city as $c) {
            $count++;
            echo $count;
            echo '<br>';
        }
        die();
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

        if ($model->load(Yii::$app->request->post()) && $model->saveReview()) {
            $file = UploadedFile::getInstance($model, 'img');

            if ($file != null) {
                $file = $model->uploadFile($file);
            }

            return $this->actionConfurm($model->city);

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}