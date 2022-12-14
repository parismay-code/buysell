<?php

use yii\web\View;
use app\assets\AppAsset;

/**
 * @var View $this
 * @var string $content
 */

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

$class = match (Yii::$app->getErrorHandler()->exception->statusCode) {
    404 => 'not-found',
    default => 'server',
};
?>

<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="ru" class="<?= "html-$class"?>">
    <head>
        <title>Куплю Продам</title>
        <?php $this->head(); ?>
    </head>
    <?php $this->beginBody(); ?>
    <body class="<?= "body-$class" ?>">

    <main>
        <?= $content ?>
    </main>

    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>