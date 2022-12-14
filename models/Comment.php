<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $author_id
 * @property int $offer_id
 * @property string $text
 * @property string|null $creation_date
 *
 * @property User $author
 * @property Offer $offer
 */
class Comment extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['author_id', 'offer_id', 'text'], 'required'],
            [['author_id', 'offer_id'], 'integer'],
            [['text'], 'string'],
            [['creation_date'], 'safe'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::class, 'targetAttribute' => ['offer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'offer_id' => 'Offer ID',
            'text' => 'Text',
            'creation_date' => 'Creation Date',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Offer]].
     *
     * @return ActiveQuery
     */
    public function getOffer(): ActiveQuery
    {
        return $this->hasOne(Offer::class, ['id' => 'offer_id']);
    }
}
