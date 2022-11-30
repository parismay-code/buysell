<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use VK\Client\VKApiClient;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;
use VK\Exceptions\VKOAuthException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class VkAuth extends Model
{
    private array $scope = [VKOAuthUserScope::WALL, VKOAuthUserScope::EMAIL];
    private array $fields = ['email', 'photo_200_orig', 'first_name'];

    /**
     * Обращается к API Вконтакте, запрашивая переадресацию с кодом на доверенный URI
     *
     * @param string $target
     *
     * @return void
     */
    public function auth(string $target): void
    {
        $redirectUri = match ($target) {
            'login' => Url::to(['vk/redirect'], true),
            'registration' => Url::to(['registration/index'], true)
        };

        $oauth = new VKOAuth();
        $url = $oauth->getAuthorizeUrl(
            VKOAuthResponseType::CODE,
            Yii::$app->params['vkClientId'],
            $redirectUri,
            VKOAuthDisplay::POPUP,
            $this->scope,
        );

        Yii::$app->response->redirect($url);
    }

    /**
     * Обращается к API Вконтакте, запрашивая токен доступа, передавая айди приложения, секретный ключ и доверенный URI
     *
     * @param string $code
     * @param string $target
     *
     * @throws VKClientException
     * @throws VKOAuthException
     *
     * @return array
     */
    public function getToken(string $code, string $target = 'login'): array
    {
        $redirectUri = match ($target) {
            'login' => Url::to(['vk/redirect'], true),
            'registration' => Url::to(['registration/index'], true)
        };

        $oauth = new VKOAuth();
        return $oauth->getAccessToken(
            Yii::$app->params['vkClientId'],
            Yii::$app->params['vkClientSecret'],
            $redirectUri,
            $code
        );
    }

    /**
     * Обращается к API Вконтакте для получения пользователя по его ID
     *
     * @param array $token
     *
     * @throws VKApiException
     * @throws VKClientException
     *
     * @return array
     */
    public function getUserData(array $token): array
    {
        $api = new VKApiClient();
        $accessToken = $token['access_token'];
        $userId = $token['user_id'];

        $result = [];

        $users = $api->users()
            ->get($accessToken, [
                'user_ids' => $userId,
                'fields' => $this->fields
            ]);

        if (count($users) === 1) {
            $result = $users[0];
        }

        return $result;
    }
}