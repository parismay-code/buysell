<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\Offer;
use app\models\Comment;

class CommentsController extends Controller
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
                        'actions' => ['index', 'delete'],
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
        $query = Offer::find()
            ->leftJoin('comment', 'offer.id = comment.offer_id')
            ->andFilterWhere(['offer.author_id' => Yii::$app->user->id])
            ->andWhere('comment.id is not null')
            ->orderBy('comment.creation_date DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete(int $id): Response
    {
        $comment = Comment::findOne($id);

        if (!$comment) {
            throw new NotFoundHttpException();
        }

        if ($comment?->offer->author_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $comment->delete();

        return $this->redirect(['comments/index']);
    }
}