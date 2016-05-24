<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<?= Yii::t(
    'mail',
    'Hello {username}. You have requested to reset your password. Please follow the link below to set your new password.',
    [
        'username' => $user->username,
    ]
) ?>
<?= $resetLink ?>
