<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\Category;
use app\models\Offer;
use yii\web\NotFoundHttpException;

/**
 * @var $this Yii
 */

class OffersController extends Controller
{
    public function actionIndex(): string|Response
    {
        $newOffers = Offer::find()
            ->orderBy('id DESC')
            ->limit(8)
            ->all();

        $discussedOffers = Offer::find()
            ->limit(8)
            ->all();

        $categories = Category::find()->all();

        if (!$newOffers) {
            return $this->render('blank');
        }

        return $this->render('index', [
            'newOffers' => $newOffers,
            'discussedOffers' => $discussedOffers,
            'categories' => $categories
        ]);
    }

    public function actionView(int $id): string|Response
    {
        $offer = Offer::findOne($id);

        if (!$offer) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', ['offer' => $offer]);
    }
}