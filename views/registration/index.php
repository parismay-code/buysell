<?php

use yii\web\View;
use app\models\RegistrationForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var $model RegistrationForm
 */

?>

<section class="sign-up">
    <h1 class="visually-hidden">Регистрация</h1>
    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'form__field--invalid',
        'fieldConfig' => [
            'template' => '{input}{label}<span>{error}</span>',
            'options' => ['class' => 'form__field sign-up__field'],
            'inputOptions' => ['class' => 'js-field'],
            'errorOptions' => ['tag' => 'span'],
        ],
        'options' => ['class' => 'sign-up__form form', 'autocomplete' => 'off']
    ]); ?>
    <div class="sign-up__title">
        <?= Html::tag('h2', 'Регистрация'); ?>
        <?= Html::a('Вход', Url::to(['login/index']), ['class' => 'sign-up__link']); ?>
    </div>

    <?= $form->field(
        $model,
        'avatar',
        [
            'options' => ['class' => 'sign-up__field-avatar'],
            'template' => '<div class="sign-up__avatar-container js-preview-container">
                <div class="sign-up__avatar js-preview"></div>
                {input}{label}
            </div>'
        ]
    )
        ->fileInput(['class' => 'visually-hidden js-file-field'])
        ->label('Загрузить аватар...'); ?>

    <?= $form->field($model, 'username')
        ->textInput() ?>

    <?= $form->field($model, 'email')
        ->input('email') ?>

    <?= $form->field($model, 'password')
        ->passwordInput() ?>

    <?= $form->field($model, 'passwordRepeat')
        ->passwordInput() ?>

    <?= Html::submitButton('Создать аккаунт', ['class' => 'sign-up__button btn btn--medium js-button']); ?>

    <?= Html::a(
        'Войти через <span class="icon icon--vk"></span>',
        Url::to(['vk/auth', 'target' => 'registration']),
        ['class' => 'btn btn--small btn--flex btn--white'],
    ); ?>

    <?php ActiveForm::end(); ?>
</section>