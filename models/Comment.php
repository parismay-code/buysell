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
 * @property int $publication_id
 * @property string $text
 * @property string|null $creation_date
 *
 * @property User $author
 * @property Publication $publication
 * @property Publication[] $publications
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
            [['author_id', 'publication_id', 'text'], 'required'],
            [['author_id', 'publication_id'], 'integer'],
            [['text'], 'string'],
            [['creation_date'], 'safe'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['publication_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publication::class, 'targetAttribute' => ['publication_id' => 'id']],
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
            'publication_id' => 'Publication ID',
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
     * Gets query for [[Publication]].
     *
     * @return ActiveQuery
     */
    public function getPublication(): ActiveQuery
    {
        return $this->hasOne(Publication::class, ['id' => 'publication_id']);
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
        return $this->hasMany(Publication::class, ['id' => 'publication_id'])->viaTable('publication_comment', ['comment_id' => 'id']);
    }
}
