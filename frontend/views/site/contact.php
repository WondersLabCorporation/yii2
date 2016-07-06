<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */
/* @var $contactUsBlocks \frontend\models\StaticContent[] */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\overrides\helpers\HtmlPurifier;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?php if (!empty($contactUsBlocks)) : ?>
            <div class="col-md-6 col-sm-12">
                <?php foreach($contactUsBlocks as $contactUsBlock) : ?>
                    <h4><?= Html::encode($contactUsBlock->title) ?></h4>
                    <?php if ($contactUsBlock->type->is_image_required): ?>
                        <?= Html::img($contactUsBlock->getImageAbsoluteUrl()) ?>
                    <?php endif; ?>
                    <?= HtmlPurifier::process($contactUsBlock->content) ?>
                <?php endforeach; ?>
            </div>
        <?php endif;?>
        <div class="col-md-6 col-sm-12">
            <p>
                If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
            </p>

            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'subject') ?>

            <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

            <?= $form->field($model, 'verifyCode')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
