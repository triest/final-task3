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

function reset(){
    console.log("reset");
    var email = $("#email").val();
    console.log(email);
    $.post("reset2",
        {
            email: email,
        },
        function(data, status){
            alert("Data: " + data + "\nStatus: " + status);
        });
  /*  $.ajax({
        url: "reset2",
        type: 'POST',
        data: {email:email},
        statusCode: {
            200: function () {
                console.log("200 - Success");
                alert("Зайвка успешео создана!");

            },
            404: function (request, status, error) {
                console.log("404 - Not Found");
                console.log(error);
                alert("Ошибка. Страница не неадена!");
            },
            503: function (request, status, error) {
                console.log("503 - Server Problem");
                console.log(error);
                alert("Проблема сервера.");
            }
        },
        success: function (data) {
            //alert(data)
        },
        cache: false,
        contentType: false,
        processData: false
    });*/
}



    $("form#form").submit(function (e) {
        e.preventDefault();
        var frm = $('#form');
        var att = frm.attr("action");
        var formData = new FormData(this);
        $.ajax({
            url: att,
            type: 'POST',
            data: formData,
            statusCode: {
                200: function () {
                    console.log("200 - Success");
                    alert("Зайвка успешео создана!");
                    document.getElementById("form").reset();
                },
                404: function (request, status, error) {
                    console.log("404 - Not Found");
                    console.log(error);
                    alert("Ошибка. Страница не неадена!");
                },
                503: function (request, status, error) {
                    console.log("503 - Server Problem");
                    console.log(error);
                    alert("Проблема сервера.");
                }
            },
            success: function (data) {
                //alert(data)
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    $(document).ready(function () {
        var i = 1;
        $('#add').click(function () {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="file" name="files[]"  accept="image/x-png,image/gif,image/jpeg" class="form-control name_list" required /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });

</script>