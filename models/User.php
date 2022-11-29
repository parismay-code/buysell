<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string|null $email
 * @property string|null $password
 * @property string|null $avatar_url
 * @property int|null $vk_id
 * @property string|null $registration_date
 * @property string|null $access_token
 * @property string|null $auth_key
 *
 * @property Comment[] $comments
 * @property Publication[] $publications
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username'], 'required'],
            [['vk_id'], 'integer'],
            [['registration_date'], 'safe'],
            [['username', 'email', 'password', 'avatar_url', 'access_token', 'auth_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'avatar_url' => 'Avatar Url',
            'vk_id' => 'Vk ID',
            'registration_date' => 'Registration Date',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): User|null
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): User|null
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return ActiveQuery
     */
    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Publications]].
     *
     * @return ActiveQuery
     */
    public function getPublications(): ActiveQuery
    {
        return $this->hasMany(Publication::class, ['author_id' => 'id']);
    }
}
