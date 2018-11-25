<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\City;
use app\models\CitySearch;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Reviews */
/* @var $form yii\widgets\ActiveForm */

$cityes=City::find()->all();
$items=ArrayHelper::map($cityes,'id','name');
$params = [

];
?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'img')->fileInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_city')->dropDownList($items,$params); ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

