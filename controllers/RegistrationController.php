<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use app\models\RegistrationForm;
use app\models\VkAuth;

class RegistrationController extends Controller
{
    public function actionIndex(string $code = ''): string|Response
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

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