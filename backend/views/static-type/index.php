<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StaticTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Static Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-type-index">
    <p>
        <?= Html::a(Yii::t('backend', 'Create Static Type'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            [
                'attribute' => 'type',
                'value' => 'typeText',
                'filter' => \backend\models\StaticType::getTypeTexts(),
            ],
            [
                'attribute' => 'items_amount',
                'value' => 'itemsAmountText',
            ],
            [
                'attribute' => 'editor_type',
                'value' => 'editorTypeText',
                'filter' => \backend\models\StaticType::getEditorTypeTexts(),
            ],

            ['class' => 'common\overrides\grid\ActionColumn'],
        ],
    ]); ?>
</div>
