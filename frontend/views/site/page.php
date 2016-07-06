<?php

/* @var $this yii\web\View */
/* @var $model \frontend\models\StaticContent */

use yii\helpers\Html;
use common\overrides\helpers\HtmlPurifier;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-page">
    <h1><?= Html::encode($model->title) ?></h1>

    <?php if ($model->type->is_image_required): ?>
        <?= Html::img($model->getImageAbsoluteUrl()) ?>
    <?php endif; ?>

    <?= HtmlPurifier::process($model->content) ?>
</div>
