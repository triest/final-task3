<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Редактировать отзыв';

?>

<div class="row">
    <div class="col-md-12 ">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

        <?= Html::a('Назад', ['/review/create'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

