<?php

namespace app\controllers;

use app\models\Tag;
use app\models\Comment;
use app\models\CommentForm;
use app\models\City;
use app\models\Reviews;
use Response;
use yii\helpers\Url;

//use Codeception\Step\Comment;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use Yii;
use yii\data\Pagination;
use yii\db\Exception;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;
use yii\httpclient\Client;

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
        $this->vardump($city);
        $city2 = City::find()->where(['name' => $city])->one();
        $this->vardump($city2);
        if ($city2 != null) {
            $reviews = $city2->getReviews()->all();
        }
        return $this->render('test', ['reviews' => $reviews, 'city' => $city2]);
    }

    public function actionDenide($city)
    {
        $count = 0;
        $this->vardump($city);

     /*   $city_in_base=City::find()
            ->where(['name'=>$city])
            ->one();
        $this->vardump($city_in_base);*/
      //  $this->vardump($city_in_base);
      /*  foreach ($city as $c) {
            $count++;
            echo $count;
            echo '<br>';
        }*/
        $query = new Query;
        $query->select([
                'city.name AS name'
            ]
        )
            ->from('city')
            ->join('RIGHT  JOIN', 'reviews',
                'reviews.id_city =city.id')
            ->distinct()
            ->orderBy('name')
            ->LIMIT(5);


        $command = $query->createCommand();
        $data = $command->queryAll();
        $this->vardump($data);
        // die();
        return $this->render('cityList', ['cityes' => $data]);
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

    public function actionList()
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $name;
    }

    public function actionTest()
    {
        Yii::$app->mailer->compose()
            ->setFrom('sakura-testmail@sakura-city.info')
            ->setTo('triest21@gmail.com')
            ->setSubject('Email sent from Yii2-Swiftmailer')
            ->send();

        /*  Yii::$app->mailer->compose(['html' => '@app/mail/html'], ['token'=>'token'])
              ->setFrom('sakura-testmail@sakura-city.info')
              ->setTo('6ded6@rambler.ru')
              ->setSubject('Please confurm you email')
              ->send();*/
        echo 'send';
    }

    function vardump($var)
    {
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    function actionConfurm2($token)
    {
        // echo $token;
        $user=User::find()->where(['emailToken'=>$token])->one();
        //  $this->vardump($user);
        $user->emailConfurm=1;
        $user->save();
        $this->redirect('/login',302);
    }
}