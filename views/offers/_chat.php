<?php

use yii\web\View;
use app\models\Chat;
use app\models\Offer;
use app\models\ChatForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var View $this
 * @var ChatForm $model
 * @var Offer $offer
 */

$chat = new Chat();

?>

<section class="chat visually-hidden">
    <h2 class="chat__subtitle">Чат с продавцом</h2>
    <ul class="chat__conversation">
        <?php foreach ($chat->getMessages($offer) as $message): ?>
            <li class="chat__message">
                <div class="chat__message-title">
                    <span class="chat__message-author">
                        <?= $message['user_id'] === Yii::$app->user->id ? 'Вы' : 'Продавец' ?>
                    </span>
                    <time class="chat__message-time" datetime="<?= $message['creation_date'] ?>">
                        <?= date('H:i', strtotime($message['creation_date'])) ?>
                    </time>
                </div>
                <div class="chat__message-content">
                    <p><?= $message['text'] ?></p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '{input}',
            'options' => ['tag' => false]
        ],
        'options' => ['class' => 'chat__form']
    ]); ?>

        <?= Html::activeHiddenInput($model, 'authorId', ['value' => $offer->author_id]); ?>
        <?= Html::activeHiddenInput($model, 'offerId', ['value' => $offer->id]); ?>

        <?= $form->field($model, 'text')
                ->textarea(['class' => 'chat__form-message', 'placeholder' => 'Ваше сообщение']); ?>

        <?= Html::submitButton(' ', ['class' => 'chat__form-button', 'aria-label' => 'Отправить сообщение в чат']); ?>
    <?php ActiveForm::end(); ?>
</section>
