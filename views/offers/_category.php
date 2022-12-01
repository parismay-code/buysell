<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Category $category
 * @var integer $offersCount
 */

?>

<li class="categories-list__item">
    <a href="<?= Url::to(['offers/category/?id=' . $category->id]); ?>" class="category-tile category-tile--default">
                <span class="category-tile__image">
                    <img src="<?= Yii::getAlias('@web/img/cat.jpg') ?>"
                         srcset="<?= Yii::getAlias('@web/img/cat@2x.jpg') ?> 2x" alt="Иконка категории">
                </span>
        <span class="category-tile__label">
            <?= Html::encode($category->label) ?> <span class="category-tile__qty js-qty"><?= $offersCount ?></span></span>
    </a>
</li>
