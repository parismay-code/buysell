<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CommentForm extends Model
{
    public ?int $offerId = null;
    public ?string $text = null;

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            [['offerId', 'text'], 'required'],
            [['offerId'], 'integer'],
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
            'text' => 'Текст'
        ];
    }

    public function comment(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $comment = new Comment();

        $comment->author_id = Yii::$app->user->id;
        $comment->offer_id = $this->offerId;
        $comment->text = $this->text;
        $comment->creation_date = date('Y-m-d H:i:s', time());

        return $comment->save(false);
    }
}