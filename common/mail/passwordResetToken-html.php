<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <?= Yii::t(
        'mail',
        "<p>Hello {username}.</p>\n\r<p>You have requested to reset your password. Please follow the link below to set your new password.</p>",
        [
            'username' => $user->username,
        ]
    ) ?>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
