<?php

use app\models\Offer;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Offer $offer
 * @var string $page
 */

$offerRedirectUrl = match (Url::current()) {
    '/my' => Url::to(['offers/edit', 'id' => $offer->id]),
    default => Url::to(['offers/view', 'id' => $offer->id]),
}

?>

<li class="tickets-list__item js-card">
    <div class="ticket-card ticket-card--color01">
        <div class="ticket-card__img">
            <img src="<?= $offer->image_url ?>" alt="Изображение товара">
        </div>
        <div class="ticket-card__info">
            <span class="ticket-card__label"><?= $offer->getType(); ?></span>
            <div class="ticket-card__categories">
                <?php foreach ($offer->categories as $category): ?>
                    <?= Html::a(Html::encode($category->label), Url::to(['offers/category', 'id' => $category->id])); ?>
                <?php endforeach; ?>
            </div>
            <div class="ticket-card__header">
                <h3 class="ticket-card__title">
                    <a href="<?= $offerRedirectUrl ?>">
                        <?= Html::encode($offer->title) ?>
                    </a>
                </h3>
                <p class="ticket-card__price">
                    <span class="js-sum"><?= Html::encode($offer->price) ?></span> ₽
                </p>
            </div>
            <?php if ($page === 'main'): ?>
                <div class="ticket-card__desc">
                    <p><?= Html::encode($offer->description) ?></p>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($page === 'owner'): ?>
            <?= Html::a('Удалить', Url::to(['offers/delete', 'id' => $offer->id]), ['class' => 'ticket-card__del js-delete']); ?>
        <?php endif; ?>
    </div>
</li>
