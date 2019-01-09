<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <? if ($sended) { ?>
                    <h5>На указаный Вами при регистрации Email отправлено письмо для подтверждения регистрации.
                        Проверьте свой почтовый ящик и перейдите по сслыке в письме.</h5>
                <? } else { ?>
                    <h5>Ошибка сервера. Попробуйте позже или свяжитесь с администратором.</h5>
                <? } ?>
            </div>
        </div>
    </div>
</div>
