<?php

namespace app\models;

use Yii;
use yii\base\Model;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database\Reference;

class Chat extends Model
{
    private Reference $reference;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $factory = (new Factory)->withDatabaseUri(Yii::$app->params['firebaseUrl']);
        $database = $factory->createDatabase();
        $this->reference = $database->getReference('chat/message');
    }

    function createMessage(int $authorId, int $offerId, string $text): Reference
    {
        return $this->reference->push([
            'author_id' => $authorId,
            'offer_id' => $offerId,
            'text' => $text,
            'user_id' => Yii::$app->user->id,
            'creation_date' => date('Y-m-d H:i:s', time()),
            'offer_id__author_id' => $offerId . ' ' . Yii::$app->user->id
        ]);
    }

    function getMessages(Offer $offer): array
    {
        return $this->reference
                ->orderByChild('offer_id__author_id')
                ->equalTo($offer->id . ' ' . Yii::$app->user->id)
                ->getValue() ?? [];
    }
}