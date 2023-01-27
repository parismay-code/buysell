<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class OfferForm extends Model
{
    public ?string $photo = null;
    public ?string $title = null;
    public ?string $description = null;
    public array $categories = [];
    public ?int $price = null;
    public ?string $type = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'description', 'categories', 'price', 'type'], 'required'],
            [['title'], 'string', 'min' => 10, 'max' => 100],
            [['description'], 'string', 'min' => 50, 'max' => 1000],
            [['type'], 'string'],
            [['price'], 'integer', 'min' => 100],
            [['categories'], 'safe'],
            [['photo'], 'file', 'maxFiles' => 1]
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels(): array
    {
        return [
            'photo' => 'Изображение',
            'title' => 'Название',
            'description' => 'Описание',
            'categories' => 'Категории',
            'price' => 'Цена',
            'type' => 'Тип',
        ];
    }

    public function create(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $offer = new Offer();

        $offer->author_id = Yii::$app->user->id;
        $offer->type = $this->type;
        $offer->title = $this->title;
        $offer->description = $this->description;
        $offer->price = $this->price;

        $offer->creation_date = date('Y-m-d H:i:s', time());

        $file = new File();

        $fileData = UploadedFile::getInstance($this, 'photo');

        if ($fileData && $file->upload($fileData)) {
            $offer->image_url = $file->url;
        } else {
            $this->addError('photo', 'Необходимо загрузить фотографию.');
            return false;
        }

        if ($offer->save(false)) {
            foreach ($this->categories as $category) {
                $offerCategory = new OfferCategory();

                $offerCategory->offer_id = $offer->id;
                $offerCategory->category_id = $category;

                $offerCategory->save(false);
            }

            return true;
        }

        return false;
    }

    public function change(int $id): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $offer = Offer::findOne($id);

        $offer->author_id = Yii::$app->user->id;
        $offer->type = $this->type;
        $offer->title = $this->title;
        $offer->description = $this->description;
        $offer->price = $this->price;

        $file = new File();

        $fileData = UploadedFile::getInstance($this, 'photo');

        if ($fileData && $file->upload($fileData)) {
            $offer->image_url = $file->url;
        }

        if ($offer->update(false)) {
            $offerCategories = OfferCategory::findAll(['offer_id' => $offer->id]);

            foreach ($offerCategories as $offerCategory) {
                $offerCategory->delete();
            }

            foreach ($this->categories as $category) {
                $offerCategory = new OfferCategory();

                $offerCategory->offer_id = $offer->id;
                $offerCategory->category_id = $category;

                $offerCategory->save(false);
            }

            return true;
        }

        return false;
    }
}