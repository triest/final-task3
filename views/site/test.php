
<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = "Список городов";
?>


<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php
                if(Yii::$app->user->isGuest){ ?>
                    <?php foreach($reviews as $review):?>
                        <article class="post">
                            <div class="post-thumb">

                            </div>
                            <div class="post-content">
                                <header class="entry-header text-center text-uppercase">
                                    <h4><b> <?= $review->title ?></b></h6>
                                        <h5><?= $review->getCityName() ?> </h5>
                                        <h6>Рейтинг: <?= $review->rating ?> </h4>
                                    Картинка:  <img src="<?= $review->getImage();?>" alt="">
                                    <div class="entry-content">
                                    </div>
                                </header>

                                <div class="entry-content">
                                    <img src="<?= $review->getImage();?>" alt=""></a>
                                </div>

                            </div>
                        </article>
                    <?php endforeach; ?>

                    <?php
                }
                else{ ?>
                    <?php foreach($reviews as $review):?>
                        <article class="post">
                            <div class="post-thumb">

                            </div>
                            <div class="post-content">
                                <header class="entry-header text-center text-uppercase">
                                    <h4><b> <?= $review->title ?></b></h6>
                                        <h5><?= $review->getCityName() ?> +</h5>
                                        <h6>Рейтинг: <?= $review->rating ?> </h4>
                                    Картинка: <?= $review->getImage(); ?>
                                    <div class="entry-content">

                                    </div>
                                </header>
                                Автор:   <b> <?= $review->getAuthor() ?></b>


                                <div class="entry-content">
                                    <br>
                                    <b>Отзыв:<br></b>
                                    <?= $review->description ?>
                                    <img src="<?= $review->getImage();?>" alt=""></a>
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