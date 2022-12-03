<?php

use yii\widgets\ActiveForm;
use app\models\OfferForm;
use app\models\Offer;
use yii\helpers\Html;

/**
 * @var OfferForm $model
 * @var array $categoryItems
 * @var string $submitTitle
 */

?>

<?php $form = ActiveForm::begin([
    'errorCssClass' => 'form__field--invalid',
    'fieldConfig' => [
        'template' => '{input}{label}{error}',
        'options' => ['class' => 'form__field'],
        'inputOptions' => ['class' => 'js-field'],
        'errorOptions' => ['tag' => 'span'],
    ],
    'options' => ['class' => 'ticket-form__form form', 'autocomplete' => 'off']
]); ?>
<?= $form->field(
    $model,
    'photo',
    [
        'options' => ['class' => 'ticket-form__field-avatar'],
        'template' => '<div class="ticket-form__avatar-container js-preview-container">
                        <div class="ticket-form__avatar js-preview"></div>
                        {input}{label}{error}
                    </div>'
    ]
)
    ->fileInput(['class' => 'visually-hidden js-file-field'])
    ->label('Загрузить фото...'); ?>

<div class="ticket-form__content">
    <div class="ticket-form__row">
        <?= $form->field($model, 'title')
            ->textInput(); ?>
    </div>
    <div class="ticket-form__row">
        <?= $form->field($model, 'description')
            ->textarea(['cols' => 30, 'rows' => 10]); ?>
    </div>
    <?= $form->field(
        $model,
        'categories[]',
        [
            'template' => '{input}',
            'options' => [
                'class' => 'ticket-form__row'
            ]
        ]
    )
        ->dropDownList($categoryItems, [
            'class' => 'form__select js-multiple-select',
            'data-label' => 'Выбрать категорию публикации'
        ]) ?>
    <div class="ticket-form__row">
        <?= $form->field($model, 'price', ['options' => ['class' => 'form__field form__field--price']])
            ->input('number', ['class' => 'js-field js-price', 'id' => 'price-field']); ?>

        <?= $form->field($model, 'type', [
            'options' => ['class' => 'form__switch switch'],
            'template' => '<div class="form__switch switch">' .
                '{input}' .
                '</div>'
        ])
            ->radioList(
                [Offer::TYPE_BUY => 'Куплю', Offer::TYPE_SELL => 'Продам'],
                [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        return '<div class="switch__item">' .
                            '<input type="radio" id="' . $value . '-field' . '" name="' . $name . '" value ="' . $value . '" class="visually-hidden">' .
                            '<label for="' . $value . '-field' . '" class="switch__button">' . $label . '</label>' .
                            '</div>';
                    },
                    'class' => 'form__switch switch'
                ],
            ); ?>
    </div>
</div>
<?= Html::submitButton($submitTitle, ['class' => 'form__button btn btn--medium js-button']); ?>
<?php ActiveForm::end(); ?>