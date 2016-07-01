<?php

use backend\models\StaticType;
use WondersLabCorporation\UnlimitedNumber\UnlimitedNumberInputWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StaticType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="static-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'items_amount')->widget(UnlimitedNumberInputWidget::className()) ?>

    <?= $form->field($model, 'editor_type')->dropDownList(StaticType::getEditorTypeTexts()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
