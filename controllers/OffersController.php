<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\Category;
use app\models\Offer;
use app\models\OfferForm;
use yii\web\NotFoundHttpException;

/**
 * @var $this Yii
 */
class OffersController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['owner', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $offer = Offer::findOne(Yii::$app->request->get('id'));

                            return $offer?->author_id === Yii::$app->user->id;
                        }
                    ],
                ],
                'denyCallback' => fn() => Yii::$app->response->redirect(['login/index']),
            ]
        ];
    }

    public function actionIndex(): string
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

    public function actionOwner(): string
    {
        $offers = Offer::findAll(['author_id' => Yii::$app->user->id]);

        return $this->render('owner', [
            'offers' => $offers
        ]);
    }

    public function actionCreate(): string|Response
    {
        $model = new OfferForm();

        $categories = Category::find()->all();

        if ($model->load($this->request->post()) && $model->create()) {
            return $this->redirect(Url::to(['offers/owner']));
        }

        return $this->render('create', ['model' => $model, 'categories' => $categories]);
    }

    public function actionDelete(int $id): Response
    {
        $offer = Offer::findOne($id);

        $offer->delete();

        return $this->redirect(Url::to(['offers/owner']));
    }

    public function actionEdit(int $id): string|Response
    {
        try {
            $offer = Offer::findOne($id);

            if (!$offer) {
                throw new NotFoundHttpException();
            }

            $model = new OfferForm();

            $categories = Category::find()->all();

            if ($model->load($this->request->post()) && $model->change($id)) {
                return $this->redirect(Url::to(['offers/owner']));
            }

            return $this->render('edit', ['offer' => $offer, 'model' => $model, 'categories' => $categories]);
        } catch (NotFoundHttpException $e) {
            return $this->render(Url::to(['error/404']));
        }
    }

    public function actionView(int $id): string|Response
    {
        try {
            $offer = Offer::findOne($id);

            if (!$offer) {
                throw new NotFoundHttpException();
            }

            return $this->render('view', ['offer' => $offer]);
        } catch (NotFoundHttpException $e) {
            return $this->redirect(Url::to(['error/404']));
        }
    }
}