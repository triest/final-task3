<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<!--main content start-->
<br><br><br><br><br>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">

                        <?php foreach ($cityes as $item): ?>
                            <?= $item["name"] ?>
                        <?php endforeach; ?>

                    </div>
                </article>
            </div>
        </div>
    </div>
</div>

<!-- end main content-->
<!--footer start-->
