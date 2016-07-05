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

    <?php if ($model->isNewRecord || $model->type == StaticType::TYPE_PAGE) : ?>
        <?= $form->field($model, 'slug')
            ->widget(
            // Adjusting Unlimited number widget to truncate field value when checkbox is checked
            UnlimitedNumberInputWidget::className(),
            [
                'unlimitedValue' => null,
                'checkboxOptions' => ['label' => Yii::t('backend', 'Generate automatically')],
                'options' => ['type' => 'text'],
            ]
        ) ?>
    <?php endif; ?>

    <?= $form->field($model, 'items_amount')->widget(UnlimitedNumberInputWidget::className()) ?>

    <?= $form->field($model, 'editor_type')->dropDownList(StaticType::getEditorTypeTexts()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
