<?php

use backend\models\StaticType;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StaticContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', '{type} items', ['type' => $searchModel->type->name]);
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    'title',
    [
        'attribute' => 'content',
        'format' => 'html',
        'value' => function ($model) {
            return StringHelper::truncate($model->content, 128, '...', null, true);
        }
    ],
];

if ($searchModel->type->type != \backend\models\StaticType::TYPE_PAGE_BLOCK) {
    // TODO: Show as a link to frontend
    $columns[] = [
        'attribute' => 'slug',
        'format' => 'raw',
        'value' => function ($model) {
            if (!isset(Yii::$app->components['frontendUrlManager'])) {
                return $model->slug;
            }
            return Html::a(
                'site/' . $model->type->slug . '/' . $model->slug,
                Yii::$app->frontendUrlManager->createAbsoluteUrl([
                    'site/page',
                    'typeSlug' => $model->type->slug,
                    'titleSlug' => $model->slug,
                ]),
                [
                    'target' => '_blank',
                    'title' => Yii::t('backend', 'View on frontend'),
                ]
            );
        }
    ];
}

$columns[] = [
    'attribute' => 'status',
    'value' => 'statusText',
    'filter' => \backend\models\StaticContent::getStatusTexts(),
];
$columns[] = ['class' => 'common\overrides\grid\ActionColumn'];
?>
<div class="static-content-index">
    <?= $this->render('_disabledWarning', ['model' => $searchModel->type]); ?>
    <p>
        <?= Html::a(Yii::t('backend', 'Create {type}', ['type' => $searchModel->type->name]), ['create', 'type_id' => $searchModel->type_id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>
</div>
