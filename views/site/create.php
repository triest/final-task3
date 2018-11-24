<?php
$this->title ="Новый отзыв";
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="leave-comment mr0"><!--leave comment-->
    <div class="row">
        <div class="col-md-12 ">
            <div class="site-login">



                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-1 control-label'],
                    ],
                ]); ?>

                <?= $form->field($model, 'description')->textInput(['autofocus' => true])->label("name") ?>


                <?= $form->field($model, 'description')->textarea() ?>

                <?= $form->field($model, 'rating')->input('number', ['min' => 1, 'max' => 5]) ?>

                <?= $form->field($model, 'img')->fileInput(['maxlength' => true]) ?>


                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::submitButton('Создать отзыв', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

                <div class="col-lg-offset-1" style="color:#999;">
                    You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                    To modify the username/password, please check out the code <code>app\models\User::$users</code>.
                </div>
            </div>
        </div>
    </div>
</div>

