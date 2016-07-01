<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\StaticContent */

$this->title = Yii::t('backend', 'Create {type} Static Content', ['type' => $model->type->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '{type} Static Content Items', ['type' => $model->type->name]), 'url' => ['index', 'type_id' => $model->type_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-content-create">
    <div class="row">
        <div class="col-lg-6 col-md-12">
            
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
