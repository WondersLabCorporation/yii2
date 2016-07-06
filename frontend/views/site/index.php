<?php

/* @var $this yii\web\View */
/* @var $mainCTABlock \frontend\models\StaticContent */
/* @var $secondaryCTABlock \frontend\models\StaticContent */
/* @var $homeBlocks \frontend\models\StaticContent[] */

use yii\helpers\Html;
use common\overrides\helpers\HtmlPurifier;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <?php if (!empty($mainCTABlock)) : ?>
        <div class="jumbotron">
            <h1><?= Html::encode($mainCTABlock->title) ?></h1>

            <div class="lead">
                <?php if ($mainCTABlock->type->is_image_required): ?>
                    <?= Html::img($mainCTABlock->getImageAbsoluteUrl()) ?>
                <?php endif; ?>
                <?= HtmlPurifier::process($mainCTABlock->content) ?>
            </div>
        </div>
    <?php endif ;?>

    <?php if (!empty($secondaryCTABlock)) : ?>
        <div>
            <h2><?= Html::encode($secondaryCTABlock->title) ?></h2>
            <?php if ($secondaryCTABlock->type->is_image_required): ?>
                <?= Html::img($secondaryCTABlock->getImageAbsoluteUrl()) ?>
            <?php endif; ?>
            <?= HtmlPurifier::process($secondaryCTABlock->content) ?>
        </div>
    <?php endif ;?>

    <div class="body-content">

        <div class="row">
            <?php if (!empty($homeBlocks)) : ?>
                <?php foreach ($homeBlocks as $homeBlock) : ?>
                    <div class="col-lg-4">
                        <h3><?= Html::encode($homeBlock->title) ?></h3>
                        <?php if ($homeBlock->type->is_image_required): ?>
                            <?= Html::img($homeBlock->getImageAbsoluteUrl()) ?>
                        <?php endif; ?>
                        <?= HtmlPurifier::process($homeBlock->content) ?>
                    </div>
                <?php endforeach;?>
            <?php endif ;?>
        </div>

    </div>
</div>
