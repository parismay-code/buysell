<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "offer".
 *
 * @property int $id
 * @property int $author_id
 * @property string $type
 * @property string $title
 * @property string|null $description
 * @property string|null $image_url
 * @property int|null $price
 * @property string|null $creation_date
 *
 * @property User $author
 * @property Category[] $categories
 * @property Comment[] $comments
 * @property OfferCategory[] $offerCategories
 */
class Offer extends ActiveRecord
{
    const TYPE_BUY = 'buy';
    const TYPE_SELL = 'sell';

    const TYPE_MAP = [
        self::TYPE_BUY => 'Купить',
        self::TYPE_SELL => 'Продать'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'offer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['author_id', 'type', 'title'], 'required'],
            [['author_id', 'price'], 'integer'],
            [['description'], 'string'],
            [['creation_date'], 'safe'],
            [['type', 'title', 'image_url'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
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
            'type' => 'Type',
            'title' => 'Title',
            'description' => 'Description',
            'image_url' => 'Image Url',
            'price' => 'Price',
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
     * Gets query for [[Categories]].
     *
     * @throws InvalidConfigException
     *
     * @return ActiveQuery
     */
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->viaTable('offer_category', ['offer_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return ActiveQuery
     */
    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['offer_id' => 'id']);
    }

    /**
     * Gets query for [[OfferCategories]].
     *
     * @return ActiveQuery
     */
    public function getOfferCategories(): ActiveQuery
    {
        return $this->hasMany(OfferCategory::class, ['offer_id' => 'id']);
    }

    /**
     * Возвращает текстовое значение текущего типа на русском языке
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_MAP[$this->type];
    }
}
