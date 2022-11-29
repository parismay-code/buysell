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
 * @property PublicationCategory[] $publicationCategories
 * @property Publication[] $publications
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
     * Gets query for [[PublicationCategories]].
     *
     * @return ActiveQuery
     */
    public function getPublicationCategories(): ActiveQuery
    {
        return $this->hasMany(PublicationCategory::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Publications]].
     *
     * @throws InvalidConfigException
     *
     * @return ActiveQuery
     */
    public function getPublications(): ActiveQuery
    {
        return $this->hasMany(Publication::class, ['id' => 'publication_id'])->viaTable('publication_category', ['category_id' => 'id']);
    }
}
