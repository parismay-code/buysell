<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $url
 * @property string $type
 */
class File extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['url', 'type'], 'required'],
            [['url', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'type' => 'Type',
        ];
    }

    /**
     * Загружает файл в базу данных
     *
     * @param UploadedFile $file
     *
     * @throws Exception
     *
     * @return bool
     */
    public function upload(UploadedFile $file): bool
    {
        if (!file_exists("@webroot/uploads")) {
            FileHelper::createDirectory("uploads");
        }

        $extension = $file->getExtension();

        $name = uniqId('upload') . ".$extension";

        $file->saveAs("@webroot/uploads/$name");

        $this->url = "/uploads/$name";
        $this->type = $extension;

        return $this->save();
    }
}
