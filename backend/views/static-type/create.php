<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\StaticType */

$this->title = Yii::t('backend', 'Create Static Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Static Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-type-create">
    <div class="row">
        <div class="col-lg-6 col-md-12">
            
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
