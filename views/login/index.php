<?php

use yii\web\View;
use app\models\LoginForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var LoginForm $model
 */

?>

<section class="login">
    <h1 class="visually-hidden">Логин</h1>
    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'form__field--invalid',
        'fieldConfig' => [
            'template' => '{input}{label}<span>{error}</span>',
            'options' => ['class' => 'form__field login__field'],
            'inputOptions' => ['class' => 'js-field'],
            'errorOptions' => ['tag' => 'span'],
        ],
        'options' => ['class' => 'login__form form', 'autocomplete' => 'off']
    ]); ?>
    <div class="login__title">
        <?= Html::a('Регистрация', Url::to(['registration/index']), ['class' => 'login__link']); ?>
        <?= Html::tag('h2', 'Вход'); ?>
    </div>

    <?= $form->field($model, 'email', ['enableAjaxValidation' => true])
            ->input('email'); ?>

    <?= $form->field($model, 'password', ['enableAjaxValidation' => true])
        ->passwordInput(); ?>

    <?= Html::submitButton('Войти', ['class' => 'login__button btn btn--medium js-button']); ?>

    <?= Html::a(
        'Войти через <span class="icon icon--vk"></span>',
        Url::to(['vk/auth', 'target' => 'login']),
        ['class' => 'btn btn--small btn--flex btn--white'],
    ); ?>

    <?php ActiveForm::end(); ?>
</section>
