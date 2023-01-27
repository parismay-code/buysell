<?php

use yii\web\View;
use app\models\Offer;
use yii\data\ActiveDataProvider;
use BuySell\helpers\NormalizeHelpers;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var Offer[] $newOffers
 */

$offersCount = $dataProvider->count;

$titleWord = 'Найдено';

$offersCountSymbols = str_split((string)$offersCount);

if ($offersCountSymbols[count($offersCountSymbols) - 1] === '1') {
    $titleWord = 'Найдена';
}

?>

<section class="search-results">
    <h1 class="visually-hidden">Результаты поиска</h1>
    <?php if ($offersCount === 0): ?>
        <div class="search-results__wrapper">
            <div class="search-results__message">
                <p>Не найдено <br>ни&nbsp;одной публикации</p>
            </div>
        </div>
    <?php else: ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_offer',
            'layout' => '<p class="search-results__label">' .
                $titleWord . ' <span class="js-results">' .
                $offersCount . " " . NormalizeHelpers::getNounPluralForm($offersCount, 'публикация', 'публикации', 'публикаций') .
                '</span>' .
                '</p>' .
                '<ul class="search-results__list">{items}</ul>' .
                '<div class="search-results__pagination">{pager}</div>',
            'itemOptions' => [
                'tag' => 'li',
                'class' => 'search-results__item',
            ],
            'options' => ['class' => 'search-results__wrapper'],
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
    <?php endif; ?>
</section>
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
