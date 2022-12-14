<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var View $this
 * @var string $subtitle
 */

?>

<section class="error">
    <h1 class="error__title"><?= Yii::$app->getErrorHandler()->exception->statusCode; ?></h1>
    <h2 class="error__subtitle"><?= $subtitle ?></h2>
    <ul class="error__list">
        <?php if (Yii::$app->user->isGuest): ?>
            <li class="error__item">
                <?= Html::a('Вход и регистрация', Url::to(['login/index'])); ?>
            </li>
        <?php else: ?>
            <li class="error__item">
                <?= Html::a('Новая публикация', Url::to(['offers/create'])); ?>
            </li>
        <?php endif; ?>
        <li class="error__item">
            <?= Html::a('Главная страница', Url::to(['offers/index'])); ?>
        </li>
    </ul>
    <form class="error__search search search--small" method="get" action="#" autocomplete="off">
        <input type="search" name="query" placeholder="Поиск" aria-label="Поиск">
        <div class="search__icon"></div>
        <div class="search__close-btn"></div>
    </form>
    <?= Html::a(
        Html::img(Yii::getAlias('@web/img/logo.svg'), ['width' => 179, 'height' => 34, 'alt' => 'Логотип Куплю Продам']),
        Url::to(['offers/index']),
        ['class' => 'error__logo logo']
    ); ?>
</section>
