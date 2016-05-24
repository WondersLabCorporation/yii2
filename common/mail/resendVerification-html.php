<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

if(!empty(Yii::$app->components['frontendUrlManager'])) {
    $verificationLink = Yii::$app->frontendUrlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
} else {
    $verificationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
}
?>
<div class="email-verification">
    <?= Yii::t(
        'mail',
        "<p>Hello {username}.</p>\n\r<p>Please follow the link below to verify your email address.</p>",
        [
            'username' => $user->username,
        ]
    ) ?>
    <p><?= Html::a(Html::encode($verificationLink), $verificationLink) ?></p>
</div>
