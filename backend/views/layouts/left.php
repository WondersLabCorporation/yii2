<?php

use backend\models\StaticType;

$staticContentPageTypes = [];
$staticContentBlockTypes = [];
foreach (StaticType::itemsList(false) as $id => $item) {
    // TODO: Find out a better solution instead of adding type_id everywhere
    if ($item['type'] == StaticType::TYPE_PAGE_BLOCK) {
        $staticContentBlockTypes[] = ['label' => $item['name'], 'url' => ['/static-content', 'type_id' => $id]];
    }
    else {
        $staticContentPageTypes[] = ['label' => $item['name'], 'url' => ['/static-content', 'type_id' => $id]];
    }
}

if (count($staticContentPageTypes) == 1) {
    $staticPagesMenuItem = ['label' => Yii::t('backend', 'Static Pages'), 'url' => $staticContentPageTypes[0]['url']];
} else {
    $staticPagesMenuItem = ['label' => Yii::t('backend', 'Static Pages'), 'items' => $staticContentPageTypes];
}

$items = [
    'home' => ['label' => Yii::t('backend', 'Home'), 'url' => ['site/index']],
    'static pages' => $staticPagesMenuItem,
    'static blocks' => ['label' => Yii::t('backend', 'Page blocks'), 'items' => $staticContentBlockTypes],
    'settings' => ['label' => Yii::t('backend', 'Settings'), 'items' => [
        'static content types' => ['label' => Yii::t('backend', 'Static Content Types'), 'url' => ['/static-type']],
    ]],
];

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::$app->urlManager->createUrl(['/images/logo.png']) ?>"/>
            </div>
            <div class="pull-left info">
                <p><?= \yii\helpers\Html::encode(Yii::$app->user->identity->username) ?></p>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $items,
            ]
        ) ?>

    </section>

</aside>
