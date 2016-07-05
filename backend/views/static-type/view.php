<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\StaticType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Static Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
            </p>
            
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                        'id',
                        'name',
                        'typeText',
                        'itemsAmountText',
                        'editorTypeText',
                        'statusText',
                        'created_at:datetime',
                        'updated_at:datetime',
                ],
            ]) ?>

        </div>
    </div>
</div>