<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::$app->urlManager->createUrl(['/images/logo.png']) ?>"/>
            </div>
            <div class="pull-left info">
                <p><?= Html::encode(Yii::$app->user->identity->username) ?></p>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('backend', 'Home'), 'url' => ['site/index']],
                ],
            ]
        ) ?>

    </section>

</aside>
