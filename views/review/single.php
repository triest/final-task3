<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;

$this->title = $city->name;
?>


<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <H2><?= $city->name ?></H2>

                <?php
                if (Yii::$app->user->isGuest) { ?>

                    <article class="post">
                        <div class="post-thumb">

                        </div>
                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">
                                <h4><b> <?= $review->title ?></b></h6>
                                    <h5><?= $review->getCityName() ?> </h5>
                                    <h6>Рейтинг: <?= $review->rating ?></h4> <br>
                                Картинка: <img src="<?= $review->getImage(); ?>" alt="">
                                <div class="entry-content">
                                </div>
                            </header>
                            <a href="<?= Url::toRoute(['review/view', 'id' => $review->id]); ?>" class="more-link">Detail</a>

                            <div class="entry-content">
                                <img src="<?= $review->getImage(); ?>" alt=""></a>
                            </div>

                        </div>
                    </article>


                    <?php
                } else { ?>

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
                                    Картинка: <img src="<?= $review->getImage(); ?>" alt="">
                                <?php } ?>
                                <div class="entry-content">

                                </div>
                            </header>
                            Автор: <b> <?= $review->getAuthor() ?></b>
                            Картинка: <img src="<?= $review->getImage(); ?>" alt="">
                            <br>
                            <a href="<?= Url::toRoute(['review/view', 'id' => $review->id]); ?>"
                               class="more-link">Отзыв</a>


                        </div>
                    </article>

                    <?php
                }
                ?>
            </div>


        </div>
    </div>
</div>