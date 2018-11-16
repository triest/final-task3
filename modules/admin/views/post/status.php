<?php
/**
 * Created by PhpStorm.
 * User: triest
 * Date: 11.11.2018
 * Time: 18:10
 */


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::dropDownList('status',  $post->status,[1=>"Черновик",2=>"Запись опубликована",3=>"Запись с истекшим сроком действия"], ['class'=>'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
