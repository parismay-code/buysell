<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ErrorController extends Controller
{
    public function actionIndex(): string
    {
        $this->layout = 'error.php';

        $exception = Yii::$app->getErrorHandler()->exception;

        $subtitle = match ($exception->statusCode) {
            400 => 'Некорректный запрос',
            401 => 'Ошибка авторизации',
            403 => 'Ошибка доступа',
            404 => 'Страница не найдена',
            500 => 'Ошибка сервера',
            503 => 'Сервис недоступен',
            521 => 'Сервер не работает',
            524 => 'Время ожидания истекло',
            default => 'Произошла ошибка',
        };

        return $this->render('index', ['subtitle' => $subtitle]);
    }
}