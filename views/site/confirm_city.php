<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $city;
?>
<div class="row">
    Ваш город <?= $city ?> ? <br>
    <!--  <button type="button" class="btn btn-primary">Да</button>

      <button type="button" class="btn btn-secondary">Нет</button>
  -->
    <?= Html::a('Да', ['review/confurm', 'city' => $city], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Нет', ['denide', 'city' => $city], ['class' => 'btn btn-danger']) ?>
</div>