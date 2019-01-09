<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use Yii;
use app\models\Post;
use app\models\Tag;
use app\models\Comment;
use app\models\CommentForm;
//use Codeception\Step\Comment;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\User;

?>

?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title> Подтвердите email</title>

</head>
<body>

Для подтверждения регистрации перейдите по ссылке: <br>

<?= 'http://city.ru.xsph.ru'.Url::toRoute(['auth/confurm2', 'token' => $token]); ?> <br>

</body>
</html>
<?php $this->endPage() ?>
