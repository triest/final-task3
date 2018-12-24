<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\City;
use app\models\CitySearch;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Reviews */
/* @var $form yii\widgets\ActiveForm */

$cityes = City::find()->all();
$items = ArrayHelper::map($cityes, 'id', 'name');
$params = [

];
?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'img')->fileInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_city')->dropDownList($items, $params); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>

    <div class="form-group">
        <label for="exampleInputFile">Текст отзывы</label> <br>
        <textarea name="description" id="description" rows=11 cols=93 maxlength=250
                  required></textarea>
    </div>

    <div class="form-group">
        <label for="title">Рейтинг:</label>
        <input type="number" class="form-control" id="rating" name="rating" min="1" max="10" col="10" required>
    </div>

    <input type="file" id="img" accept="image/*" name="img" value="{{ old('file')}}" required>

    <?= $form->field($model, 'id_city')->dropDownList($items, $params); ?>

    <div class="form-group">
        <label for="new_city">New city:</label>
        <input type="text" class="form-control" id="new_city" name="new_city" placeholder="Введите "
               oninput="findCity()" required>
    </div>

    <select style="width: 200px" class="new_city_select" name="new_city_select" class="form-control input-sm" id="new_city_select">
        <option value="-">-</option>
    </select>
    <script>
        function findCity() {
            console.log('xhange');
            var input = document.getElementById("new_city").value;
            console.log(input);
            $.get(
                "http://geohelper.info/api/v1/cities?apiKey=YxI8Q1NUptbUA15xS0drYEROSPki8Mq8&locale[lang]=uk&filter[name]=" + input,
                function (data, status) {
                    // console.log(data.result)
                    $('#new_city_select').empty();
                    $.each(data.result, function (index, subcatObj) {
                            console.log("item")
                            console.log(subcatObj.name);

                            $('#new_city_select').append('<option value="' + subcatObj.name + '">' + subcatObj.name + '</option>');

                        }
                    )
                }
            )
        }
    </script>


</div>
 