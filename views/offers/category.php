<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Category;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var Category $category
 * @var Category[] $categories
 * @var ActiveDataProvider $dataProvider
 */

?>

<section class="categories-list">
    <h1 class="visually-hidden">Сервис объявлений "Куплю - продам"</h1>
    <ul class="categories-list__wrapper">
        <?php foreach ($categories as $_category): ?>
            <?php $offersCount = $_category->getCategoryOffersCount(); ?>
            <?php if ($offersCount > 0): ?>
                <?=
                $this->render('_category', [
                    'category' => $_category,
                    'offersCount' => $offersCount
                ]);
                ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</section>
<section class="tickets-list">
    <h2 class="visually-hidden"><?= 'Предложения из категории ' . $category->label ?></h2>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_offer',
        'layout' => '<div class="tickets-list__header">' .
            '<p class="tickets-list__title">' .
            $category->label . '<b class="js-qty"> ' . $category->getCategoryOffersCount() . '</b>' .
            '</p>' .
            '</div>' .
            '<ul>{items}</ul>' .
            '<div class="tickets-list__pagination">{pager}</div>',
        'itemOptions' => [
            'tag' => 'li',
            'class' => 'tickets-list__item js-card',
        ],
        'options' => ['class' => 'tickets-list__wrapper'],
        'pager' => [
            'hideOnSinglePage' => true,
            'maxButtonCount' => 5,
            'options' => [
                'class' => 'pagination',
            ],
            'nextPageLabel' => 'дальше',
            'prevPageLabel' => 'назад',
            'activePageCssClass' => 'active',
        ],
    ]); ?>
</section>
