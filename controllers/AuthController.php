<?php

namespace app\controllers;

use app\models\Post;
use app\models\Tag;
use app\models\Comment;
use app\models\CommentForm;
use app\models\ResentForm;
//use Codeception\Step\Comment;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\User;


class AuthController extends Controller
{
    public function actionSingup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($user = $model->signup()) {
                $this->sendConfurmEmail($user);
                return $this->redirect(['site/login']);
            }
        }

        return $this->render('signup', ['model' => $model]);
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
            return $this->redirect(['site/index']);
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

    public function sendConfurmEmail($user)
    {

        Yii::$app->mailer->compose(['html' => '@app/mail/html'], ['token' => $user->emailToken])
            ->setFrom('sakura-testmail@sakura-city.info')
            ->setTo($user->email)
            ->setSubject('Please confurm you email')
            ->send();

        // die();
    }

    public function sentEmailConfirm($user)
    {
        $email = $user->email;
        $this->vardump($user);
        $sent = Yii::$app->mailer
            /*   ->compose(
                   ['html' => 'user-signup-comfirm-html', 'text' => 'user-signup-comfirm-text'],
                   ['user' => $user])*/
            ->compose(['html' => '@app/mail/html'], ['token' => $user->emailToken])
            ->setFrom('sakura-testmail@sakura-city.info')
            ->setTo($email)
            ->setSubject('Email sent from Yii2-Swiftmailer')
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Sending error.');
        }
    }

    public function vardump($var)
    {
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    public function actionEmail($token)
    {
        $this->vardump($token);
    }

    public function actionResent()
    {
        $model = new ResentForm();
        if ($model->load(Yii::$app->request->post())) {
            $result = Yii::$app->request->post();
            $this->vardump($result);
            $user = User::find()->where(['email' => $result->email])->one();
            $this->vardump($user);
            $this->sentEmailConfirm($user);
        }
        return $this->render('resent', [
            'model' => $model,
        ]);
    }

    function actionConfurm2($token)
    {
        // echo $token;
        $user = User::find()->where(['emailToken' => $token])->one();
        //  $this->vardump($user);
        $user->emailConfurm = 1;
        $user->save();
        $this->redirect('site/login', 302);
    }


}