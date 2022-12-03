<?php

use yii\web\View;
use app\models\Category;
use app\models\OfferForm;
use yii\helpers\ArrayHelper;

/**
 * @var View $this
 * @var OfferForm $model
 * @var Category[] $categories
 */

$categoryItems = ArrayHelper::map($categories, 'id', 'label');

?>

<section class="ticket-form">
    <div class="ticket-form__wrapper">
        <h1 class="ticket-form__title">Редактировать публикацию</h1>
        <div class="ticket-form__tile">
            <?= $this->render('_offerForm', [
                'model' => $model,
                'categoryItems' => $categoryItems,
                'submitTitle' => 'Сохранить',
            ]); ?>
        </div>
    </div>
</section>