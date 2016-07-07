<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\StaticContent */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '{type} items', ['type' => $model->type->name]), 'url' => ['index', 'type_id' => $model->type_id]];
$this->params['breadcrumbs'][] = $this->title;

$attributes = [
    'id',
    'title',
    [
        'attribute' => 'content',
        'format' => 'html',
        'value' => StringHelper::truncate($model->content, 128, '...', null, true),
    ],
];

if ($model->type->type != \backend\models\StaticType::TYPE_PAGE_BLOCK) {
    $attributes[] = [
        'attribute' => 'slug',
        'format' => 'raw',
        'value' => Html::a(
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
        ),
    ];
}

if ($model->type->is_image_required) {
    $attributes[] = [
        'attribute' => 'image',
        'format' => 'html',
        'value' => Html::img($model->getImageAbsoluteUrl()),
    ];
}

$attributes = array_merge(
    $attributes,
    [
        [
            'attribute' => 'type_id',
            'value' => $model->type->name,
        ],
        [
            'attribute' => 'status',
            'value' => $model->statusText,
        ],
        'created_at:datetime',
        'updated_at:datetime',
    ]
);
?>
<div class="static-content-view">
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <?= $this->render('_disabledWarning', ['model' => $model->type]); ?>
            <p>
                <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id, 'type_id' => $model->type_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('backend', 'Are you sure you want to delete this content item?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?php // TODO: A possibility for a good widget ?>
                <?php if ($model->status == \backend\models\StaticContent::STATUS_ACTIVE) : ?>
                    <?= Html::a(Yii::t('backend', 'Disable'), ['disable', 'id' => $model->id], [
                        'class' => 'btn btn-warning',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php else: ?>
                    <?= Html::a(Yii::t('backend', 'Activate'), ['activate', 'id' => $model->id], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
            </p>
            
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $attributes
            ]) ?>

        </div>
    </div>
</div>
