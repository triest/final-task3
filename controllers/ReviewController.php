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

}
