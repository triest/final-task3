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
                            </header>
                            <b>Content:
                            <?= $review->title ?></b>
                            <div class="entry-content">
                            </div>

                        </div>
                    </article>
                <?php endforeach; ?>

                 <?php
                   }
                   else{ ?>

                     <?php
                   }

                ?>




            </div>


        </div>
    </div>
</div>