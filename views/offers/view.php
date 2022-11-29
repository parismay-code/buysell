<?php

use yii\web\View;
use app\models\Offer;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var View $this
 * @var Offer $offer
 */

$user = Yii::$app->user->identity;

?>

<section class="ticket">
    <div class="ticket__wrapper">
        <h1 class="visually-hidden">Карточка объявления</h1>
        <div class="ticket__content">
            <div class="ticket__img">
                <img src="<?= $offer->image_url ?>" alt="Изображение товара">
            </div>
            <div class="ticket__info">
                <h2 class="ticket__title"><?= Html::encode($offer->title) ?></h2>
                <div class="ticket__header">
                    <p class="ticket__price"><span class="js-sum"><?= Html::encode($offer->price) ?></span> ₽</p>
                    <p class="ticket__action"><?= $offer->getType() ?></p>
                </div>
                <div class="ticket__desc">
                    <p><?= Html::encode($offer->description) ?></p>
                </div>
                <div class="ticket__data">
                    <p>
                        <b>Дата добавления:</b>
                        <span><?= $offer->creation_date ?></span>
                    </p>
                    <p>
                        <b>Автор:</b>
                        <a href="<?= Url::to(['user/?id=' . $offer->author_id]) ?>">
                            <?= Html::encode($offer->author->username) ?>
                        </a>
                    </p>
                    <p>
                        <b>Контакты:</b>
                        <a href="<?= Html::encode('mailto:' . $offer->author->email) ?>">
                            <?= Html::encode($offer->author->email) ?>
                        </a>
                    </p>
                </div>
                <ul class="ticket__tags">
                    <?php foreach ($offer->categories as $category): ?>
                        <li>
                            <a href="<?= Url::to(['offers/category/?id=' . $category->id]) ?>"
                               class="category-tile category-tile--small">
                                <span class="category-tile__image">
                                    <img src="<?= Yii::getAlias('@web/img/cat.jpg') ?>"
                                         srcset="<?= Yii::getAlias('@web/img/cat@2x.jpg') ?> 2x" alt="Иконка категории">
                                </span>
                                <span class="category-tile__label"><?= Html::encode($category->label) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="ticket__comments">
            <h2 class="ticket__subtitle">Комментарии</h2>
            <div class="ticket__comment-form">
                <form action="#" method="post" class="form comment-form">
                    <div class="comment-form__header">
                        <a href="<?= Url::to(['user/view/?id=' . $user->id]) ?>" class="comment-form__avatar avatar">
                            <img src="<?= $user->avatar_url ?>" alt="Аватар пользователя">
                        </a>
                        <p class="comment-form__author">Вам слово</p>
                    </div>
                    <div class="comment-form__field">
                        <div class="form__field">
                            <textarea name="comment" id="comment-field" cols="30" rows="10" class="js-field">Нормальное вообще кресло! А как насч</textarea>
                            <label for="comment-field">Текст комментария</label>
                            <span>Обязательное поле</span>
                        </div>
                    </div>
                    <button class="comment-form__button btn btn--white js-button" type="submit" disabled="">Отправить
                    </button>
                </form>
            </div>
            <div class="ticket__comments-list">
                <ul class="comments-list">
                    <?php foreach ($offer->comments as $comment): ?>
                    <li>
                        <div class="comment-card">
                            <div class="comment-card__header">
                                <a href="<?= Url::to(['user/view/?id=' . $comment->author_id]) ?>" class="comment-card__avatar avatar">
                                    <img src="<?= $comment->author->avatar_url ?>" alt="Аватар пользователя">
                                </a>
                                <p class="comment-card__author"><?= Html::encode($comment->author->username) ?></p>
                            </div>
                            <div class="comment-card__content">
                                <p><?= $comment->text ?></p>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <button class="chat-button" type="button" aria-label="Открыть окно чата"></button>
    </div>
</section>
