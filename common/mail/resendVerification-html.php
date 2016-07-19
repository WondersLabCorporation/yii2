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
        "<p>Hello {username}.</p>\n\r<p>This email was sent to you in order to verify your email address.</p>\n\r<p>Please follow the link below to proceed.</p>\n\r<p>In case you did not request this email, please ignore it.</p>",
        [
            'username' => Html::encode($user->username),
        ]
    ) ?>
    <p><?= Html::a(Html::encode($verificationLink), $verificationLink) ?></p>
</div>
