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
    'Hello {username}. Please follow the link below to verify your email address.',
    [
        'username' => $user->username,
    ]
) ?>
<?= $verificationLink ?>