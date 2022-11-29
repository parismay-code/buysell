<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "offer_category".
 *
 * @property int $offer_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Offer $offer
 */
class OfferCategory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'offer_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['offer_id', 'category_id'], 'required'],
            [['offer_id', 'category_id'], 'integer'],
            [['offer_id', 'category_id'], 'unique', 'targetAttribute' => ['offer_id', 'category_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::class, 'targetAttribute' => ['offer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'offer_id' => 'Offer ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
