<?php

use app\models\Offer;
use app\models\OfferCategory;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Offer $model
 * @var string $page
 */

if ($model::class === OfferCategory::class) {
    $model = $model->offer;
}

$type = $page ?? 'category';

$offerRedirectUrl = match (Url::current()) {
    '/my' => Url::to(['offers/edit', 'id' => $model->id]),
    default => Url::to(['offers/view', 'id' => $model->id]),
}

?>

<div class="ticket-card ticket-card--color01">
    <div class="ticket-card__img">
        <img src="<?= $model->image_url ?>" alt="Изображение товара">
    </div>
    <div class="ticket-card__info">
        <span class="ticket-card__label"><?= $model->getType(); ?></span>
        <div class="ticket-card__categories">
            <?php foreach ($model->categories as $category): ?>
                <?= Html::a(Html::encode($category->label), Url::to(['offers/category', 'id' => $category->id])); ?>
            <?php endforeach; ?>
        </div>
        <div class="ticket-card__header">
            <h3 class="ticket-card__title">
                <a href="<?= $offerRedirectUrl ?>">
                    <?= Html::encode($model->title) ?>
                </a>
            </h3>
            <p class="ticket-card__price">
                <span class="js-sum"><?= Html::encode($model->price) ?></span> ₽
            </p>
        </div>
        <?php if ($type === 'main' || $type === 'category'): ?>
            <div class="ticket-card__desc">
                <p><?= Html::encode($model->description) ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($type === 'owner'): ?>
        <?= Html::a('Удалить', Url::to(['offers/delete', 'id' => $model->id]), ['class' => 'ticket-card__del js-delete']); ?>
    <?php endif; ?>
</div>
