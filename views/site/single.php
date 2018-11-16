<?php
/**
 * Created by PhpStorm.
 * User: triest
 * Date: 05.11.2018
 * Time: 21:18
 */

use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">


                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h1 class="entry-title"><?= $post->title?></h1>
                            <div class="entry-content">
                                <b>By <?= $post->author->username?> On <?= $post->getDate();?></b>
                            </div>
                        </header>
                        <div class="entry-content">
                            <?= $post->content?>
                        </div>
                        <div class="social-share">

                            <a href="index">К списку постов</a>

                            <ul class="text-center pull-right">

                            </ul>
                        </div>
                        Теги:
                        <?php foreach($tags as $tag):?>
                            <a href="<?= Url::toRoute(['site/tag', 'tag'=>$tag]);?>"> <?= $tag ?> </a>

                        <?php endforeach; ?>
                    </div>
                    <br>

                    <b>Добавить комментарий:</b>
                    <?php $form = \yii\widgets\ActiveForm::begin([
                        'action'=>['site/comment', 'id'=>$post->id],
                        'options'=>['class'=>'form-horizontal contact-form', 'role'=>'form']])?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <?= $form->field($commentForm, 'comment')->textarea(['class'=>'form-control','placeholder'=>'Введие коментарий'])->label(false)?>
                        </div>
                    </div>
                    <button type="submit" class="btn send-btn">Отправить комментарий</button>
                    <?php \yii\widgets\ActiveForm::end();?>



                    Комментарии:
                    <?php if(!empty($comments)):?>

                        <?php foreach($comments as $comment):?>

                            <div class="bottom-comment">
                                <div class="comment-date">
                                    <b><?= $comment->create_time ?></b>
                                </div>
                                <div class="commemt-text">
                                    <?= $comment->content ?>
                                </div>

                            </div>
                        <?php endforeach ?>
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </div>
</div>
<!-- end main content-->