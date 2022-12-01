<?php

use yii\web\View;
use app\models\Offer;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var View $this
 * @var Offer[] $offers
 */

?>

<section class="tickets-list">
    <h2 class="visually-hidden">Самые новые предложения</h2>
    <div class="tickets-list__wrapper">
        <div class="tickets-list__header">
            <?= Html::a('Новая публикация', Url::to(['offers/create']), ['class' => 'tickets-list__btn btn btn--big']); ?>
        </div>
        <ul>
            <?php foreach ($offers as $offer): ?>
                <?= $this->render('_offer', ['offer' => $offer, 'page' => 'owner']) ?>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
