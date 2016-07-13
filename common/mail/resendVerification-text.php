<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

if(!empty(Yii::$app->components['frontendUrlManager'])) {
    $verificationLink = Yii::$app->frontendUrlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
} else {
    $verificationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
}
?>
<?= Yii::t(
    'mail',
    'Hello {username}. This email was sent to you in order to verify your email address. Please follow the link below to proceed. In case you did not request this email, please ignore it.',
    [
        'username' => Html::encode($user->username),
    ]
) ?>
<?= $verificationLink ?>