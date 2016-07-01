<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\StaticContent */

// TODO: Fix breadcrumbs based on type_id and items_amount. Set appropriate label
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '{type} Static Content Items', ['type' => $model->type->name]), 'url' => ['index', 'type_id' => $model->type_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-content-view">
    <div class="row">
        <div class="col-lg-6 col-md-12">

            <p>
                <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id, 'type_id' => $model->type_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'content:html',
                    'slug',
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
                ],
            ]) ?>

        </div>
    </div>
</div>
