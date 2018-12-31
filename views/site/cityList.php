<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;

?>
<!--main content start-->
<br>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                         <h2>Города, к которым уже есть отзывы:</h2><br>
                        <?php foreach ($cityes as $item): ?>
                            <h4><?= $item["name"] ?>
                                <a href="<?= Url::toRoute(['review/confurm', 'city' => $item["name"]]); ?>"
                                   class="more-link">Выбрать</a>
                            </h4>
                        <?php endforeach; ?>

                    </div>
                </article>
            </div>
        </div>
    </div>
</div>

<!-- end main content-->
<!--footer start-->
