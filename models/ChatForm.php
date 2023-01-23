<?php

namespace app\models;

use yii\base\Model;

class ChatForm extends Model
{
    public ?int $authorId = null;
    public ?int $offerId = null;
    public ?string $text = null;

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            [['offerId', 'authorId', 'text'], 'required'],
            [['offerId', 'authorId'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels(): array
    {
        return [
            'offerId' => 'Offer ID',
            'authorId' => 'Author ID',
            'text' => 'Текст'
        ];
    }

    /**
     * Авторизует пользователя на сайте
     *
     * @return bool
     */
    public function send(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $chat = new Chat();

        $chat->createMessage($this->authorId, $this->offerId, $this->text);

        return true;
    }
}