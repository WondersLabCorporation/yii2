<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\StaticType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Static Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$attributes = [
    'id',
    'name',
];

if ($model->type != \backend\models\StaticType::TYPE_PAGE_BLOCK) {
    $attributes[] = 'slug';
}

$attributes = array_merge(
    $attributes,
    [
        'typeText',
        'itemsAmountText',
        'editorTypeText',
        'statusText',
        'created_at:datetime',
        'updated_at:datetime',
    ]
);
?>
<div class="static-type-view">
    <div class="row">
        <div class="col-lg-6 col-md-12">

            <p>
                <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>

                <?php if ($model->status == \backend\models\StaticType::STATUS_ACTIVE) : ?>
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
