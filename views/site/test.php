<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;

$this->title = $city->name ;
?>


<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <H2><?= $city->name ?></H2>
                <?php
                if ($reviews == null) {
                    ?>
                    <h3>Нет отзывов.
                        Хотите создать?
                        <?= Html::a('Создать отзыв', ['/review/create'], ['class' => 'btn btn-primary']) ?>
                    </h3>
                    <?
                }
                ?>
                <?php
                if (Yii::$app->user->isGuest) { ?>
                    <?php foreach ($reviews as $review): ?>
                        <article class="post">
                            <div class="post-thumb">

                            </div>
                            <div class="post-content">
                                <header class="entry-header text-center text-uppercase">
                                    <h4><b> <?= $review->title ?></b></h6>
                                        <h5><?= $review->getCityName() ?> </h5>
                                        <h6>Рейтинг: <?= $review->rating ?></h4>
                                    Картинка: <img src="<?= $review->getImage(); ?>" alt="">
                                    <div class="entry-content">
                                    </div>
                                </header>

                                <div class="entry-content">
                                    <img src="<?= $review->getImage(); ?>" alt=""></a>
                                </div>

                            </div>
                        </article>
                    <?php endforeach; ?>

                    <?php
                } else { ?>
                    <?php foreach ($reviews as $review): ?>
                        <article class="post">
                            <div class="post-thumb">

                            </div>
                            <div class="post-content">
                                <header class="entry-header text-center text-uppercase">
                                    <h4><b> <?= $review->title ?></b></h6>
                                        <h5><?= $review->getCityName() ?> +</h5>
                                        <h6>Рейтинг: <?= $review->rating ?></h4>
                                    Картинка: <img src="<?= $review->getImage(); ?>" alt="">
                                    <?php if ($review->getImage() != null) { ?>
                                        <img src="<?= Yii::$app->request->baseUrl . $review->getImage() ?>"
                                             class=" img-responsive">
                                    <?php } ?>
                                    <div class="entry-content">

                                    </div>
                                </header>
                                Автор: <b> <?= $review->getAuthor() ?></b>


                                <div class="entry-content">
                                    <br>
                                    <b>Отзыв:<br></b>
                                    <?= $review->description ?>
                                    <img src="<?= $review->getImage(); ?>" alt=""></a>
                                </div>


                            </div>
                        </article>
                    <?php endforeach; ?>
                    <?php
                }
                ?>
            </div>


        </div>
    </div>
</div>