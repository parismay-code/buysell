<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\StaleObjectException;

class LoginForm extends Model
{
    public ?string $email = null;
    public ?string $password = null;

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            [['password'], 'string', 'min' => 6],
            [['email'], 'email'],
            [['email'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Аккаунт не найден.']
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels(): array
    {
        return [
            'email' => 'Эл. почта',
            'password' => 'Пароль',
        ];
    }

    /**
     * Авторизует пользователя на сайте
     *
     * @return bool
     */
    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findOne(['email' => $this->email]);

        if (!$user->validatePassword($this->password)) {
            $this->addError('password', 'Неверный пароль.');
            return false;
        }

        return Yii::$app->user->login($user);
    }
}