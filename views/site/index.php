<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php foreach($post as $article):?>
                    <article class="post">
                        <div class="post-thumb">
                            <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]);?>"></a>

                        </div>
                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">
                                <h6></a></h6>

                                <h1 class="entry-title"><a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]);?>"><?= $article->title?></a></h1>
                                <?= $article->getDate();?></span><ul class="text-center pull-right"></ul>

                            </header>
                            <b>Content:</b>
                            <div class="entry-content">
                                <p><?= $article->getPreview()?>
                                </p>

                                <div class="btn-continue-reading text-center text-uppercase">
                                    <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]);?>" class="more-link">Detail</a>
                                </div>
                            </div>

                        </div>
                    </article>
                <?php endforeach; ?>

                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>
            </div>


        </div>
    </div>
</div>
<!-- end main content-->
<!--footer start-->