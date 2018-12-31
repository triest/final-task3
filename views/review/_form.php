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
$items = ArrayHelper::map($cityes, "id", "name");

$SelectedItems=$model->getCityForEdit();

//$SelectedItems=[2];
//$model->vardump($selectedItems);
//$Items2=ArrayHelper::map($selectedItems, "id");

?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'img')->fileInput(['maxlength' => true]) ?>

    <div class="form-check">
        <label class="form-check-label" for="radio1">
            <input type="radio" class="form-check-input" id="radioList" name="optradio" onclick="selectList()"
                   value="list" checked>Список
        </label>
    </div>

    <?= Html::dropDownList('cities', $SelectedItems, $items, ['class' => 'form-control', 'multiple' => true,['options' => ['selected'=>true]] ]) ?>

    <div class="form-check">
        <label class="form-check-label" for="radio2">
            <input type="radio" class="form-check-input" id="radioNew" name="optradio" onclick="selectNew()"
                   value="new">Новый город
        </label>
    </div>


    <div class="form-group">
        <label for="new_city">New city:</label>
        <input type="text" class="form-control" name="new_city" id="new_city" placeholder="Введите "
               oninput="findCity()">
    </div>


    <select style="width: 200px" class="new_city_select" name="new_city_select" id="new_city_select"
            class="form-control input-sm" col="10" disabled="true"
    >
        <option value="-">-</option>
    </select>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <script>
        function findCity() {
            var input = document.getElementById("new_city").value;
            $.get(
                "http://geohelper.info/api/v1/cities?apiKey=YxI8Q1NUptbUA15xS0drYEROSPki8Mq8&locale[lang]=uk&filter[name]=" + input,
                function (data, status) {
                    $('#new_city_select').empty();
                    $.each(data.result, function (index, subcatObj) {
                            $('#new_city_select').append('<option value="' + subcatObj.name + '">' + subcatObj.name + '</option>');
                        }
                    )
                }
            )
        }

        function selectNew() {
            document.getElementById(['new_city']).disabled = false;
            document.getElementById(['new_city_select']).disabled = false;
            document.getElementById(['id_city']).readonly = true
        }

        function selectList() {
            document.getElementById(['new_city']).disabled = true;
            document.getElementById(['new_city_select']).disabled = true;
            document.getElementById(['id_city']).readonly = false;
        }
    </script>


</div>
 