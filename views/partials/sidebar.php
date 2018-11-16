<?php
use yii\helpers\Url;
?>
<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">

        <aside class="widget">
            <h5 class="widget-title text-uppercase text-center">Облако тегов</h5>

          <?   $tags=$this->context->getPoluparTags(); ?>
            <?php foreach($tags as $tag):?>
                <a href="<?= Url::toRoute(['site/tag', 'tag'=>$tag->name]);?>"> <?= $tag->name ?> </a>
            <?php endforeach; ?>

        </aside>

        <aside class="widget border pos-padding">
            <h5 class="widget-title text-uppercase text-center">Недавние комментарии:</h5>
            <ul>
            
            </ul>
        </aside>
    </div>
</div>