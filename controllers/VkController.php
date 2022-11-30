<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use app\models\User;
use app\models\VkAuth;
use VK\Exceptions\VKClientException;
use VK\Exceptions\VKOAuthException;
use yii\filters\AccessControl;

class VkController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function init(): void
    {
        parent::init();
    }

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
                        'allow' => true,
                        'roles' => ['?']
                    ],
                ]
            ]
        ];
    }

    /**
     * Обращается к API Вконтакте для получения кода доступа пользователя
     *
     * @param string $target
     *
     * @return void
     */
    public function actionAuth(string $target = 'login'): void
    {
        $oauth = new VkAuth();
        $oauth->auth($target);
    }

    /**
     * Обращается к API Вконтакте, передавая код доступа пользователя и запрашивая его токен
     *
     * @param string $code
     *
     * @throws VKClientException
     * @throws VKOAuthException
     *
     * @return Response
     */
    public function actionRedirect(string $code): Response
    {
        $oauth = new VkAuth();
        $token = $oauth->getToken($code);

        if (!$token['user_id']) {
            return $this->redirect(Url::to(['registration/index']));
        }

        $user = User::findOne(['vk_id' => $token['user_id']]);

        if (!$user) {
            return $this->redirect(Url::to(['vk/auth', 'target' => 'registration']));
        }

        Yii::$app->user->login($user);
        return $this->redirect(Url::to(['offers/index']));
    }
}