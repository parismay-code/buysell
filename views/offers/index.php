<?php

use yii\web\View;
use app\models\Offer;
use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var View $this ;
 * @var Offer[] $newOffers
 * @var Offer[] $discussedOffers
 * @var Category[] $categories
 */

?>

<section class="categories-list">
    <h1 class="visually-hidden">Сервис объявлений "Куплю - продам"</h1>
    <ul class="categories-list__wrapper">
        <?php foreach ($categories as $category): ?>
            <?php $offersCount = $category->getCategoryOffersCount(); ?>
            <?php if ($offersCount > 0): ?>
                <?=
                $this->render('_category', [
                    'category' => $category,
                    'offersCount' => $offersCount
                ]);
                ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</section>
<?php if (count($newOffers) > 0 || count($discussedOffers) > 0): ?>
    <?php if (count($newOffers) > 0): ?>
        <section class="tickets-list">
            <h2 class="visually-hidden">Самые новые предложения</h2>
            <div class="tickets-list__wrapper">
                <div class="tickets-list__header">
                    <p class="tickets-list__title">Самое свежее</p>
                </div>
                <ul>
                    <?php foreach ($newOffers as $offer): ?>
                        <li class="tickets-list__item js-card">
                            <?= $this->render('_offer', ['model' => $offer, 'page' => 'main']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>
    <?php if (count($discussedOffers) > 0): ?>
        <section class="tickets-list">
            <h2 class="visually-hidden">Самые обсуждаемые предложения</h2>
            <div class="tickets-list__wrapper">
                <div class="tickets-list__header">
                    <p class="tickets-list__title">Самые обсуждаемые</p>
                </div>
                <ul>
                    <?php foreach ($discussedOffers as $offer): ?>
                        <li class="tickets-list__item js-card">
                            <?= $this->render('_offer', ['model' => $offer, 'page' => 'main']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>
<?php else: ?>
    <div class="message">
        <div class="message__text">
            <p>На сайте еще не опубликовано ни&nbsp;одного объявления.</p>
        </div>

        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('Вход и регистрация', Url::to(['login/index']), ['class' => 'message__link btn btn--big']); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>