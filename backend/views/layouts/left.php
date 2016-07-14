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

$staticPagesMenuItem = ['label' => Yii::t('backend', 'Static Pages'), 'url' => '', 'icon' => 'fa fa-file-text-o'];
$staticPagesMenuItem = ['label' => Yii::t('backend', 'Static Pages'), 'url' => '', 'icon' => 'fa fa-file-text-o'];
if (count($staticContentPageTypes) == 1) {
    $staticPagesMenuItem['url'] = $staticContentPageTypes[0]['url'];
} else {
    $staticPagesMenuItem['items'] = $staticContentPageTypes;
}

$items = [
    'home' => ['label' => Yii::t('backend', 'Home'), 'url' => ['site/index'], 'icon' => 'fa fa-home '],
    'static pages' => $staticPagesMenuItem,
    'static blocks' => ['label' => Yii::t('backend', 'Page blocks'), 'items' => $staticContentBlockTypes, 'url' => '', 'icon' => 'fa fa-th-large'],
    'settings' => [
        'label' => Yii::t('backend', 'Settings'),
        'items' => [
            'static content types' => ['label' => Yii::t('backend', 'Static Content Types'), 'url' => ['/static-type']],
        ],
        'url' => '',
        'icon' => 'fa fa-cogs'
    ],
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
