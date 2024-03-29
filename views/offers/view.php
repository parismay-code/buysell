<?php

use yii\web\View;
use app\models\Offer;
use app\models\CommentForm;
use app\models\ChatForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Offer $offer
 * @var CommentForm $commentModel
 * @var ChatForm $chatModel
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

                        <span><?= Yii::$app->formatter->asDate($offer->creation_date, 'd MMMM Y'); ?></span>
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
                            <a href="<?= Url::to(['offers/category/', 'id' => $category->id]) ?>"
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
            <?php if (Yii::$app->user->isGuest): ?>
                <div class="ticket__warning">
                    <p>Отправка комментариев доступна <br>только для зарегистрированных пользователей.</p>
                    <?= Html::a('Вход и регистрация', Url::to(['login/index']), ['class' => 'btn btn--big']); ?>
                </div>
            <?php endif; ?>
            <h2 class="ticket__subtitle">Комментарии</h2>
            <?php if (!Yii::$app->user->isGuest): ?>
                <div class="ticket__comment-form">
                    <?php $form = ActiveForm::begin([
                        'errorCssClass' => 'form__field--invalid',
                        'fieldConfig' => [
                            'template' => '{input}{label}{error}',
                            'options' => ['class' => 'form__field'],
                            'inputOptions' => ['class' => 'js-field'],
                            'errorOptions' => ['tag' => 'span'],
                        ],
                        'options' => ['class' => 'form comment-form', 'autocomplete' => 'off']
                    ]); ?>
                    <div class="comment-form__header">
                        <a href="#" class="comment-form__avatar avatar">
                            <?= Html::img(Yii::$app->user->identity->avatar_url ?? Yii::getAlias('@web/img/placeholder.png'), ['alt' => 'Аватар пользователя']) ?>
                        </a>
                        <p class="comment-form__author">Вам слово</p>
                    </div>
                    <?= Html::activeHiddenInput($commentModel, 'offerId', ['value' => $offer->id]) ?>

                    <div class="comment-form__field">
                        <?= $form->field($commentModel, 'text')
                            ->textarea(['cols' => 30, 'rows' => 10]); ?>
                    </div>
                    <?= Html::submitButton('Отправить', ['class' => 'comment-form__button btn btn--white js-button']); ?>
                    <?php ActiveForm::end(); ?>
                </div>
            <?php endif; ?>
            <div class="ticket__comments-list">
                <ul class="comments-list">
                    <?php foreach (array_reverse($offer->comments) as $comment): ?>
                        <li>
                            <div class="comment-card">
                                <div class="comment-card__header">
                                    <a href="#"
                                       class="comment-card__avatar avatar">
                                        <?= Html::img($comment->author->avatar_url ?? Yii::getAlias('@web/img/placeholder.png'), ['alt' => 'Аватар пользователя']) ?>
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

<?= $this->render('_chat', ['model' => $chatModel, 'offer' => $offer]); ?>
