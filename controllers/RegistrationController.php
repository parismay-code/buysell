<?php

namespace app\controllers;

use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use app\models\RegistrationForm;
use app\models\VkAuth;

class RegistrationController extends Controller
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
                        'allow' => true,
                        'roles' => ['?']
                    ],
                ],
            ]
        ];
    }

    /**
     * Возвращает страницу регистрации, обрабатывает POST запрос и создает аккаунт
     *
     * @param string $code
     *
     * @throws StaleObjectException
     * @throws \Throwable
     * @throws VKApiException
     * @throws VKClientException
     *
     * @return mixed
     */
    public function actionIndex(string $code = ''): mixed
    {
        $model = new RegistrationForm();

        if ($code) {
            $oauth = new VkAuth();
            $token = $oauth->getToken($code, 'registration');

            if (!$token['user_id']) {
                return $this->redirect(Url::to(['registration/index']));
            }

            $userData = $oauth->getUserData($token);

            if ($model->vkRegister($userData)) {
                return $this->redirect(Url::to(['offers/index']));
            }
        }

        if ($model->load($this->request->post()) && $model->register()) {
            return $this->redirect(Url::to(['offers/index']));
        }


        $model->password = null;
        $model->passwordRepeat = null;

        return $this->render('index', ['model' => $model]);
    }
}