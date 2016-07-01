<?php

use backend\models\StaticType;

$staticContentTypes = StaticType::activeItemsList();
$staticContentTypesMenuItems = [];
foreach (StaticType::activeItemsList() as $id => $name) {
    // TODO: Find out a better solution instead of adding type_id everywhere
    $staticContentTypesMenuItems[] = ['label' => $name, 'url' => ['/static-content', 'type_id' => $id]];
}

$items = [
    'home' => ['label' => Yii::t('backend', 'Home'), 'url' => ['site/index']],
    'static content' => ['label' => Yii::t('backend', 'Static Content'), 'items' => $staticContentTypesMenuItems],
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
                <p><?= Yii::$app->user->identity->username ?></p>
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
