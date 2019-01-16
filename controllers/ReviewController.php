<?php

namespace app\controllers;


use app\models\City;
use app\models\Reviews;
use app\models\User;

//use Codeception\Step\Comment;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
//use App\User;
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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
        if (\Yii::$app->user->isGuest) {
            $this->goHome();
        }

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
                $city = City::find()
                    ->where(['=', 'name', $new_city])
                    ->one();;
                if ($city == null) {
                    $city = new City;
                    $city->name = $new_city;
                    $city->save();
                    $model->saveCity($city);
                }
                $model->saveCities($city);
                $model->save(false);

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
        return $this->asJson($name);
    }


    public function actionConfurm($city)
    {
        $session = Yii::$app->session; // получаем сессию
        $session['city'] = [
            'name' => $city,
            'lifetime' => 2 * 60 * 60 //запомнить на 2 часа
        ];
        $city2 = City::find()->where(['name' => $city])->one();
        if ($city2 != null) {
            $reviews = Reviews::find()   //add reviews visout city
                ->select('reviews.*')
                ->leftJoin('city_review', '`city_review`.`review_id` = `reviews`.`id`')
                ->where(['city_review.city_id' => null])
                ->orWhere(['city_review.city_id' => $city2->id])
                ->all();
            return $this->render('index', ['reviews' => $reviews, 'city' => $city2->name, 'title' => $city2->name]);
        } else {
            return $this->render('index', ['city' => $city, 'title' => $city]);
        }
    }


    public function actionView($id)
    {
        $review = Reviews::find()->where(['id' => $id])->one();
        return $this->render('single', ['review' => $review]);
    }

    //возвращает на предудущию страницк
    public function actionBack()
    {
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    //получает даные автора.
    public function actionAuthordata($id)
    {
        $user = User::find()->where(['id' => $id])->one();
        $id = $user->id;
        $fio = $user->fio;
        $email = $user->email;
        $phone = $user->phone;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $items = ['id' => $id, 'fio' => $fio, 'email' => $email, 'phone' => $phone];
        return $items;
    }

    //поимк всех отзывов автора
    public function actionGetreviewsbyautor($id)
    {
        $user = User::find()->where(['id' => $id])->one();
        if ($user != null) {
            $reviews = $user->getReviews()->all();
            return $this->render('index', ['reviews' => $reviews, 'title' => $user->fio]);
        }
        throw new \yii\web\NotFoundHttpException("Your Error Message.");
    }

    public function actionEdit($id)
    {
        $review = Reviews::find()->where(['id' => $id])->one();
        //если отправка формы
        $post = Yii::$app->request->post();
        if ($review->load($post)) {
            if ($review->load($post) && $review->saveReview()) {
                //получаем новый свисок городов
                $cities = Yii::$app->request->post('cities'); //забирем города из запроса
                if ($cities != null) {
                    $review->saveCities($cities);
                }
                return $this->actionView($id);
            }
        }

        if ($review == null) {
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        } else {
            return $this->render('edit', ['model' => $review]);
        }
    }

    public function actionMyreview()
    {
        $user = Yii::$app->user->identity;
        if ($user == null) {
            return $this->redirect(['auth/login']);
        } else {
            $reviews = $user->getReviews()->all();
            return $this->render('index', ['reviews' => $reviews, 'title' => $user->username]);
        }
    }

}
