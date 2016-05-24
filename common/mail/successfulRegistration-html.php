<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $verificationLink string */
?>
<div class="email-verification">
    <?= Yii::t(
        'mail',
        "<p>Hello {username},</p>\n\r<p>You have successfully registered on {appname}</p>\n\r<p>Please follow the link below to verify your email address.</p>",
        [
            'username' => $user->username,
            'appname' => Yii::$app->name,
        ]
    ) ?>
    <p><?= Html::a(Html::encode($verificationLink), $verificationLink) ?></p>
</div>
