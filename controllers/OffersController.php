<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\Category;
use app\models\OfferCategory;
use app\models\Offer;
use app\models\OfferForm;
use app\models\CommentForm;
use app\models\ChatForm;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\widgets\ActiveForm;

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
                        'actions' => ['index', 'view', 'category', 'search'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['owner', 'create', 'delete', 'edit'],
                        'allow' => true,
                        'roles' => ['@'],
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
            ->leftJoin('(SELECT offer_id, COUNT(*) count from comment GROUP BY offer_id) comment', 'offer.id = comment.offer_id')
            ->andWhere('comment.count is not null')
            ->orderBy('comment.count DESC')
            ->limit(8)
            ->all();

        $categories = Category::find()->all();

        return $this->render('index', [
            'newOffers' => $newOffers,
            'discussedOffers' => $discussedOffers,
            'categories' => $categories
        ]);
    }

    public function actionSearch(): string
    {
        $query = Offer::find()
            ->where('MATCH(title) AGAINST (:search_query)')
            ->addParams(['search_query' => $this->request->get('query') ?? '']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ]
        ]);

        $newOffers = Offer::find()
            ->orderBy('id DESC')
            ->limit(8)
            ->all();

        return $this->render('search', ['dataProvider' => $dataProvider, 'newOffers' => $newOffers]);
    }

    public function actionCategory(int $id): string
    {
        $category = Category::findOne($id);

        if (!$category || count($category->offers) === 0) {
            throw new NotFoundHttpException();
        }

        $query = OfferCategory::find()
            ->leftJoin('offer', 'offer_category.offer_id = offer.id')
            ->andFilterWhere(['category_id' => $id])
            ->orderBy('offer.id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ]
        ]);

        $categories = Category::find()->all();


        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'category' => $category,
            'categories' => $categories
        ]);
    }

    public function actionOwner(): string
    {
        $offers = Offer::findAll(['author_id' => Yii::$app->user->id]);

        $query = Offer::find()
            ->where(['author_id' => Yii::$app->user->id])
            ->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ]
        ]);

        return $this->render('owner', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate(): mixed
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

        if (!$offer) {
            throw new NotFoundHttpException();
        }

        if ($offer?->author_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $offer->delete();

        return $this->redirect(Url::to(['offers/owner']));
    }

    public function actionEdit(int $id): mixed
    {
        $offer = Offer::findOne($id);

        if (!$offer) {
            throw new NotFoundHttpException();
        }

        if ($offer->author_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model = new OfferForm();

        $categories = Category::find()->all();

        if ($model->load($this->request->post()) && $model->change($id)) {
            return $this->redirect(Url::to(['offers/owner']));
        }

        return $this->render('edit', ['offer' => $offer, 'model' => $model, 'categories' => $categories]);
    }

    public function actionView(int $id): mixed
    {
        $offer = Offer::findOne($id);

        if (!$offer) {
            throw new NotFoundHttpException();
        }

        $commentModel = new CommentForm();
        $chatModel = new ChatForm();

        if ($commentModel->load($this->request->post()) && $commentModel->comment()) {
            return $this->redirect(Url::to(['offers/view', 'id' => $id]));
        }

        if ($chatModel->load($this->request->post()) && $chatModel->send()) {
            return $this->redirect(Url::to(['offers/view', 'id' => $id]));
        }

        $chatModel->text = null;
        $commentModel->text = null;

        return $this->render('view', ['offer' => $offer, 'commentModel' => $commentModel, 'chatModel' => $chatModel]);
    }
}