<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;

$this->title = $review->title;
?>


<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php
                if (Yii::$app->user->isGuest) { ?>

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

                            <?php if ($review->getImage() != null) { ?>
                                <img src="<?= Yii::$app->request->baseUrl . $review->getImage() ?>"
                                     class=" img-responsive">
                            <?php } ?>

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
                                <? $user = Yii::$app->user->identity ?>
                                <? if ($user->id = $review->id_autor) { ?>
                                    <br>
                                    <?= Html::a('Редактировать', ['review/edit', 'id' => $review->id], ['class' => 'btn btn-primary']) ?>
                                    <br>
                                <? } ?>
                                Картинка: <img src="<?= $review->getImage(); ?>" alt="">


                                <?php if ($review->getImage() != null) { ?>
                                    <img src="<?= Yii::$app->request->baseUrl . $review->getImage() ?>"
                                         class=" img-responsive">
                                <?php } ?>
                                <div class="entry-content">

                                </div>
                            </header>
                            Автор: <b><a id="open-button"
                                         onclick="showAuthor(<?= $review->id_autor ?>)"> <?= $review->getAuthor() ?></a></b>
                            <br>
                            <?= $review->description ?>
                        </div>
                    </article>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">

        <span id="close1" class="close">&times;</span>

        <p name="fio" id="fio"></p>
        <p name="email" id="email"></p>
        <p name="phone" id="phone"></p>
        <a name="link" id="link">Отзывы автора</a>

    </div>

</div>

<script>
    function showAuthor(id) {
        //console.log(id);
        getAuthorData(id);
        //  $(".modal-content #fio").text(id.toString());
        modal.style.display = "block";
    }

    function getAuthorData(id) {
        console.log('het ' + id);
        var id2 = id;
        $.get("authordata",
            {id: id},
            function (data, status) {
                console.log(data)
                $(".modal-content #fio").text(data.fio);
                $(".modal-content #email").text("Email: " + data.email);
                $(".modal-content #phone").text("Телефон:" + data.phone);
                var id2 = data.id;
                console.log('id ' + id2);
                $(".modal-content #link").attr("href",
                    "<?= Url::toRoute(['review/getreviewsbyautor']);?>" + "?id=" + id2);
            });
    }

    // Get the modal
    var modal = document.getElementById('myModal');
    // Get the button that opens the modal
    // Get the <span> element that closes the modal
    // var span = document.getElementsByClassName("close")[0];
    var span = document.getElementById("close1");
    // When the user clicks the button, open the modal
    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        console.log("clouse");
        modal.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>