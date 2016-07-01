<?php

use backend\models\StaticContent;
use backend\models\StaticType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StaticContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="static-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php switch ($model->type->editor_type) :
        case StaticType::EDITOR_TYPE_WYSIWYG : ?>
            <?php // TODO: Adjust TinyMCE according to generic needs ?>
            <?= $form->field($model, 'content')->widget(\dosamigos\tinymce\TinyMce::className(), []) ?>
        <?php break; ?>
        <?php case StaticType::EDITOR_TYPE_TEXTAREA : ?>
            <?= $form->field($model, 'content')->textarea(['maxlength' => true]) ?>
        <?php break; ?>
        <?php case StaticType::EDITOR_TYPE_TEXTINPUT : ?>
            <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>
        <?php break;
            endswitch; ?>


    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
