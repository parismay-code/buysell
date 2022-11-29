<?php

use app\models\Offer;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Offer $publication
 */

?>

<li class="tickets-list__item">
    <div class="ticket-card ticket-card--color01">
        <div class="ticket-card__img">
            <img src="<?= $publication->image_url ?>" alt="Изображение товара">
        </div>
        <div class="ticket-card__info">
            <span class="ticket-card__label"><?= $publication->getType(); ?></span>
            <div class="ticket-card__categories">
                <?php foreach ($publication->categories as $category): ?>
                    <a href="<?= Url::to(['offers/category/?id=' . $category->id]) ?>">
                        <?= Html::encode($category->label) ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="ticket-card__header">
                <h3 class="ticket-card__title">
                    <a href="<?= Url::to(['offers/view/?id=' . $publication->id]) ?>">
                        <?= Html::encode($publication->title) ?>
                    </a>
                </h3>
                <p class="ticket-card__price">
                    <span class="js-sum"><?= Html::encode($publication->price) ?></span> ₽
                </p>
            </div>
            <div class="ticket-card__desc">
                <p><?= Html::encode($publication->description) ?></p>
            </div>
        </div>
    </div>
</li>
