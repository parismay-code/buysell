<?php

use yii\web\View;
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var View $this
 * @var string $content
 */

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">

    <head>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>
    <?php $this->beginBody() ?>

    <header class="header <?= !Yii::$app->user->isGuest ? 'header--logged' : '' ?> ">
        <div class="header__wrapper">
            <?= Html::a(
                Html::img(Yii::getAlias('@web/img/logo.svg'), ['width' => 179, 'height' => 34, 'alt' => 'Логотип Куплю Продам']),
                Url::to(['offers/index']),
                ['class' => 'header__logo logo']
            ); ?>

            <nav class="header__user-menu">
                <ul class="header__list">
                    <li class="header__item <?= Url::current() === '/my' ? 'header__item--active' : '' ?>">
                        <?= Html::a('Публикации', Url::to(['offers/owner'])); ?>
                    </li>
                    <li class="header__item <?= Url::current() === '/comments' ? 'header__item--active' : '' ?>">
                        <?= Html::a('Комментарии', Url::to(['comments/index'])); ?>
                    </li>
                </ul>
            </nav>

            <form class="search" method="get" action="#" autocomplete="off">
                <input type="search" name="query" placeholder="Поиск" aria-label="Поиск">
                <div class="search__icon"></div>
                <div class="search__close-btn"></div>
            </form>

            <?= Html::a(
                Html::img(Yii::$app->user->identity->avatar_url ?? null, ['alt' => 'Аватар пользователя']),
                Url::to(['offers/index']),
                ['class' => 'header__avatar avatar']
            ); ?>

            <?= Html::a('Вход и регистрация', Url::to(['login/index']), ['class' => 'header__input']); ?>
        </div>
    </header>

    <main class="page-content">
        <?= $content ?>
    </main>

    <footer class="page-footer">
        <div class="page-footer__wrapper">
            <div class="page-footer__col">
                <a href="#" class="page-footer__logo-academy" aria-label="Ссылка на сайт HTML-Академии">
                    <svg width="132" height="46">
                        <use xlink:href="img/sprite_auto.svg#logo-htmlac"></use>
                    </svg>
                </a>
                <p class="page-footer__copyright">© 2019 Проект Академии</p>
            </div>
            <div class="page-footer__col">
                <?= Html::a(
                    Html::img(Yii::getAlias('@web/img/logo.svg'), ['width' => 179, 'height' => 35, 'alt' => "Логотип Куплю Продам"]),
                    Url::to(['offers/index']),
                    ['class' => 'page-footer__logo logo']
                ); ?>
            </div>
            <div class="page-footer__col">
                <ul class="page-footer__nav">
                    <li>
                        <?= Html::a('Вход и регистрация', Url::to(['login/index']), ['class' => 'header__input']); ?>
                    </li>
                    <li>
                        <?= Html::a('Создать объявление', Url::to(['offers/create']), ['class' => 'header__input']); ?>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>

    </html>
<?php $this->endPage() ?>