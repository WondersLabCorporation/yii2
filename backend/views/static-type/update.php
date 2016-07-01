<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StaticType */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Static Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Static Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="static-type-update">
    <div class="row">
        <div class="col-lg-6 col-md-12">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
