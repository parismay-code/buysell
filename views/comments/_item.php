<?php

use app\models\Offer;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Offer $model
 */

?>

<div class="comments__header">
    <a href="<?= Url::to(['offers/view', 'id' => $model->id]) ?>" class="announce-card">
        <h2 class="announce-card__title"><?= Html::encode($model->title) ?></h2>
        <span class="announce-card__info">
          <span class="announce-card__price">₽ <?= Html::encode($model->price) ?></span>
          <span class="announce-card__type"><?= $model->getType() ?></span>
        </span>
    </a>
</div>
<ul class="comments-list">
    <?php foreach (array_reverse($model->comments) as $comment): ?>
        <li class="js-card">
            <div class="comment-card">
                <div class="comment-card__header">
                    <a href="#" class="comment-card__avatar avatar">
                        <?= Html::img(Yii::$app->user->identity->avatar_url ?? Yii::getAlias('@web/img/placeholder.png'), ['alt' => 'Аватар пользователя']) ?>
                    </a>
                    <p class="comment-card__author"><?= Html::encode($model->author->username) ?></p>
                </div>
                <div class="comment-card__content">
                    <p><?= Html::encode($comment->text) ?></p>
                </div>
                <?= Html::a('Удалить', Url::to(['comments/delete', 'id' => $comment->id]), ['class' => 'comment-card__delete js-delete']); ?>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
