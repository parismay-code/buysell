<?php

use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

/**
 * @var Yii $this
 * @var ActiveDataProvider $dataProvider
 */

?>

<section class="comments">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'layout' => '{items}',
        'emptyText' => 'У ваших публикаций еще нет комментариев.',
        'emptyTextOptions' => [
            'tag' => 'p',
            'class' => 'comments__message',
        ],
        'itemOptions' => [
            'class' => 'comments__block',
        ],
        'options' => ['class' => 'comments__wrapper']
    ]); ?>
</section>