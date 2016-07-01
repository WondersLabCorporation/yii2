<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StaticContent */

$this->title = Yii::t('backend', 'Update {type} Static Content: ', [
    'type' => $model->type->name,
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '{type} Static Content Items', ['type' => $model->type->name]), 'url' => ['index', 'type_id' => $model->type_id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id, 'type_id' => $model->type_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="static-content-update">
    <div class="row">
        <div class="col-lg-6 col-md-12">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
