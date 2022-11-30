<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\base\Model;
use app\validators\ClearStringValidator;
use yii\db\StaleObjectException;

class RegistrationForm extends Model
{
    public ?string $avatar = null;
    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $passwordRepeat = null;

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'email'], 'string'],
            [['username', 'email', 'password', 'passwordRepeat'], 'required'],
            [['avatar'], 'file', 'maxFiles' => 1],
            [['username'], ClearStringValidator::class],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email'],
            [['password', 'passwordRepeat'], 'string', 'min' => 6],
            [['passwordRepeat'], 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels(): array
    {
        return [
            'username' => 'Имя и фамилия',
            'email' => 'Эл. почта',
            'password' => 'Пароль',
            'passwordRepeat' => 'Пароль еще раз',
            'avatar' => 'Аватар'
        ];
    }

    /**
     * Создает аккаунт нового пользователя, обрабатывая данные, пришедшие в POST запросе
     *
     * @throws \Throwable
     * @throws StaleObjectException
     *
     * @return bool
     */
    public function register(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();

        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->registration_date = date('Y-m-d H:i:s', time());

        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->access_token = Yii::$app->security->generateRandomString();

        $file = new File();

        $fileData = UploadedFile::getInstance($this, 'avatar');

        if ($fileData && $file->upload($fileData)) {
            $user->avatar_url = $file->url;
        }

        if ($user->save(false)) {
            return Yii::$app->user->login($user);
        }

        return false;
    }

    public function vkRegister(array $data): bool
    {
        $user = new User();

        $user->vk_id = $data['id'] ?? null;
        $user->username = $data['first_name'] ?? null;
        $user->email = $data['email'] ?? null;
        $user->avatar_url = $data['photo_200_orig'] ?? null;

        $user->registration_date = date('Y-m-d H:i:s', time());

        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->access_token = Yii::$app->security->generateRandomString();

        if ($user->save(false)) {
            return Yii::$app->user->login($user);
        }

        return false;
    }
}