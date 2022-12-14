<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

?>

<section class="tickets-list">
    <h2 class="visually-hidden">Самые новые предложения</h2>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_offer',
        'showOnEmpty' => true,
        'viewParams' => ['page' => 'owner'],
        'layout' => '<div class="tickets-list__header">' .
            Html::a('Новая публикация', Url::to(['offers/create']), ['class' => 'tickets-list__btn btn btn--big']) .
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
