<?php

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
            $urlText = 'site/' . $model->type->slug . '/' . $model->slug;
            if (!$model->isActive()) {
                // Model is disabled, so no frontend page exist
                return $urlText;
            }
            return Html::a(
                $urlText,
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
$columns[] = [
    'class' => 'common\overrides\grid\ActionColumn',
    'template' =>  "{view}\n\r{update}\n\r{delete}\n\r{disable}\n\r{activate}",
    'buttons' => [
        // Overriding links to unclude type_id into url. Required for menu highlighting
        // TODO: Remove this once a better solution is found
        'view' => function ($url, $model, $key) {
            $link = Html::a(Yii::t('yii', '{viewIcon} View', ['viewIcon' => '<span class="glyphicon glyphicon-eye-open"></span>']), ['/static-content/view', 'id' => $model->id, 'type_id' => $model->type_id], [
                'title' => Yii::t('yii', 'View'),
                'aria-label' => Yii::t('yii', 'View'),
                'data-pjax' => '0',
            ]);
            return Html::tag('div', $link, ['class' => 'view-action-wrapper']);
        },
        'update' => function ($url, $model, $key) {
            $link = Html::a(Yii::t('yii', '{updateIcon} Update', ['updateIcon' => '<span class="glyphicon glyphicon-pencil"></span>']), ['/static-content/update', 'id' => $model->id, 'type_id' => $model->type_id], [
                'title' => Yii::t('yii', 'Update'),
                'aria-label' => Yii::t('yii', 'Update'),
                'data-pjax' => '0',
            ]);
            return Html::tag('div', $link, ['class' => 'view-action-wrapper']);
        },
    ],
];
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
