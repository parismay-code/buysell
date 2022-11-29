<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $label
 * @property string|null $image_url
 *
 * @property OfferCategory[] $offerCategories
 * @property Offer[] $offers
 */
class Category extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'label'], 'required'],
            [['name', 'label', 'image_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'label' => 'Label',
            'image_url' => 'Image Url',
        ];
    }

    /**
     * Gets query for [[OfferCategories]].
     *
     * @return ActiveQuery
     */
    public function getOfferCategories(): ActiveQuery
    {
        return $this->hasMany(OfferCategory::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Offers]].
     *
     * @throws InvalidConfigException
     *
     * @return ActiveQuery
     */
    public function getOffers(): ActiveQuery
    {
        return $this->hasMany(Offer::class, ['id' => 'offer_id'])->viaTable('offer_category', ['category_id' => 'id']);
    }

    public function getCategoryOffersCount(): int
    {
        return count(OfferCategory::findAll(['category_id' => $this->id]));
    }
}
