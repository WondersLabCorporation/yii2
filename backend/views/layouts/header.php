<?php
use yii\bootstrap\Nav;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a(
        '<span class="logo-mini">'
            . Yii::$app->name
            . '</span><span class="logo-lg">'
            . Yii::$app->name
            . '</span>',
        Yii::$app->homeUrl,
        ['class' => 'logo']
    ) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <?= Nav::widget([
                'options' => [
                    'class' => 'pull-right navbar-nav nav',
                ],
                'items' => [
                    [
                        'label' => Yii::t('backend', 'Logout'),
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    ],
                ]
            ]) ?>
        </div>
    </nav>
</header>
