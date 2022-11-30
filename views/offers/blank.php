<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="message">
    <div class="message__text">
        <p>На сайте еще не опубликовано ни&nbsp;одного объявления.</p>
    </div>

    <?php if (Yii::$app->user->isGuest): ?>
        <?= Html::a('Вход и регистрация', Url::to(['login/index']), ['class' => 'message__link btn btn--big']); ?>
    <?php endif; ?>
</div>
