<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StaticContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', '{type} Static Content Items', ['type' => $searchModel->type->name]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-content-index">
    <p>
        <?= Html::a(Yii::t('backend', 'Create {type} Static Content Item', ['type' => $searchModel->type->name]), ['create', 'type_id' => $searchModel->type_id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            // TODO: Show as HTML and truncate
            'content',
            // TODO: Show as a link to frontend
            'slug',
            [
                'attribute' => 'typeName',
                'value' => 'type.name',
            ],

            ['class' => 'common\overrides\grid\ActionColumn'],
        ],
    ]); ?>
</div>
