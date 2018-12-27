<?php

namespace app\controllers;

use app\models\Tag;
use app\models\Comment;
use app\models\CommentForm;
use app\models\City;
use app\models\Reviews;

//use Codeception\Step\Comment;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use http\Env\Response;
use Yii;
use yii\data\Pagination;
use yii\db\Exception;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;

class ReviewController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    // ...
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


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new Reviews();
        $request = Yii::$app->request;
        $radio = $request->post("optradio");

        if ($model->load($request->post()) && $model->saveReview()) {
            $file = UploadedFile::getInstance($model, 'img');
            if ($file != null) {
                $file = $model->uploadFile($file);
            }

            $cities = Yii::$app->request->post('cities'); //забирем города из запроса
            if ($cities != null) {
                $model->saveCities($cities);
            }

            if ($request->post() and $radio == "new") {
                $new_city = $request->post("new_city_select");
                $this->vardump($new_city);
                $city = City::find()
                    ->where(['=', 'name', $new_city])
                    ->one();;
                $this->vardump($city);
                if ($city == null) {
                    $city = new City;
                    $city->name = $new_city;
                    $city->save(false);
                    $model->id_city = $city->id;
                    $model->save(false);
                }

            }


            return $this->actionConfurm($model->city);
        }

        $cities = ArrayHelper::map(City::find()->all(), 'id', 'name');

        return $this->render('create', [
            'model' => $model,
            'cities' => $cities
        ]);
    }

    public function actionList()
    {
        $request = Yii::$app->request;
        $name = $request->get('name');

        /*
                $client = new Client();
                $response = $client->createRequest()
                    ->setMethod('POST')
                    ->setUrl('http://example.com/api/1.0/users')
                    ->setData(['name' => 'John Doe', 'email' => 'johndoe@example.com'])
                    ->send();
                if ($response->isOk) {
                    $newUserId = $response->data['id'];
                    var_dump($newUserId);
                }
        */
        return $this->asJson($name);
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

    public function actionConfurm($city)
    {
        $city2 = City::find()->where(['name' => $city])->one();
        if ($city2 != null) {
            $reviews = $city2->getReviews()->all();
            return $this->render('test', ['reviews' => $reviews, 'city' => $city2]);
        }
        return $this->render('test');
    }

    public function actionView($id)
    {
        $review = Reviews::find($id)->one();
        // $this->vardump($review);
        return $this->render('single', ['review' => $review]);
    }

    //возвращает на предудущию страницк
    public function actionBack()
    {
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }
}
