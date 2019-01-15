<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'ResetPass';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="form-group">
    <label for="name">Email:</label>
    <input type="text" class="form-control" id="email" name="email" required="required" placeholder="Введите email"
           required>
</div>
<input type="button" onclick="reset()" value="Сбросить">

<script type="text/javascript">

    function reset() {
        var email = $("#email").val();
        data2 = "";
        $.post("resetpassmail",
            {
                email: email,
            },
            function (data, status) {
                if (status = "success") {
                    alert("Письмо отправленно");
                }
                else {
                    alert("Ошибка.")
                }

            });
    }
</script>