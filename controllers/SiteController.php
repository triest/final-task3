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


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $session = Yii::$app->session; // получаем сессию
        if ($session->has('city')) {  //если есть переменая города, то сразу вонзращаем страницу с отзывами для него
            $city = $session['city'];
            $city2 = City::find()->where(['name' => $city])->one();
            if ($city2 != null) {
                return $this->redirect(['review/confurm', 'city' => $city2->name]);
            } else {
                return $this->actionDenide();
            }
        } else {
            $headers = Yii::$app->request->headers; //получем заголовки
            $ip = $headers["forwarded"];
            $ip = substr($ip, 4, strlen($ip)); //обрезаем ip
            $request = file_get_contents("http://api.sypexgeo.net/json/" . $ip); //запрашиваем местоположение
            $array = json_decode($request);
            $session['city'] = $array->city->name_ru;
            return $this->render('confirm_city', ['city' => $array->city->name_ru]);
        }
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


    //
    public function actionDenide($city = '')
    {
        $query = new Query;
        $query->select([
                'city.name AS name'
            ]
        )
            ->from('city')
            ->join('RIGHT  JOIN', 'city_review',
                'city_review.city_id =city.id')
            ->distinct()
            ->orderBy('name', 'ASC');

        $command = $query->createCommand();
        $data = $command->queryAll();
        return $this->render('cityList', ['cityes' => $data]);
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


}