<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;

$this->title = $review->title
?>


<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <H2><?= $city->name ?></H2>

                <?php
                if (Yii::$app->user->isGuest) { ?>
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
                                <br>
                                <div class="entry-content">

                                </div>
                            </header>
                            Автор: <b> <?= $review->getAuthor() ?></b> <br>
                            <img src="<?= $review->getImage(); ?>" alt="">
                            <br>
                            <?= $review->description ?> <br>
                        
                            <? echo \yii\helpers\Html::a('Назад',Yii::$app->request->referrer)?>
                        </div>
                    </article>

                    <?php
                }
                ?>
            </div>


        </div>
    </div>
</div>