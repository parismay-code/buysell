<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;

class LoginController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ]
        ];
    }

    public function actionIndex(): string|array|Response
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

        $model = new LoginForm();

        if ($this->request->isAjax && $model->load($this->request->post())) {
            $this->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load($this->request->post()) && $model->login()) {
            return $this->redirect(Url::to(['offers/index']));
        }

        $model->password = null;

        return $this->render('index', ['model' => $model]);
    }

}