<?php

use yii\web\View;
use app\models\Offer;
use app\models\Category;

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
<section class="tickets-list">
    <h2 class="visually-hidden">Самые новые предложения</h2>
    <div class="tickets-list__wrapper">
        <div class="tickets-list__header">
            <p class="tickets-list__title">Самое свежее</p>
        </div>
        <ul>
            <?php foreach ($newOffers as $offer): ?>
                <?= $this->render('_offer', ['offer' => $offer, 'page' => 'main']); ?>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
<section class="tickets-list">
    <h2 class="visually-hidden">Самые обсуждаемые предложения</h2>
    <div class="tickets-list__wrapper">
        <div class="tickets-list__header">
            <p class="tickets-list__title">Самые обсуждаемые</p>
        </div>
        <ul>
            <?php foreach ($discussedOffers as $offer): ?>
                <?= $this->render('_offer', ['offer' => $offer, 'page' => 'main']); ?>
            <?php endforeach; ?>
        </ul>
    </div>
</section>