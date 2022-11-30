<?php

namespace app\validators;

use yii\base\Model;
use yii\validators\Validator;

class ClearStringValidator extends Validator
{
    const BAD_SYMBOLS = [
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '+', '-',
        '"', '№', ';', ':', '?',
        ',', "'", '.', '/', '\\', '|', '`', '<', '>', '{', '}', '[', ']',
    ];

    /**
     * Проверяет, содержит ли строка цифры или специальные символы
     *
     * @param Model $model
     * @param string $attribute
     *
     * @return void
     */
    public function validateAttribute($model, $attribute): void
    {
        $values = str_split($model->attributes[$attribute]);

        foreach ($values as $value) {
            if (in_array($value, self::BAD_SYMBOLS)) {
                $model->addError($attribute, 'Значение не может содержать цифры или специальные символы.');
            }
        }
    }

}