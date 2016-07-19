<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

/* @var $user common\models\User */
/* @var $verificationLink string */
?>
<?= 
    Yii::t(
        'mail',
        'Hello {username}. You have successfully registered on {appname} website. Please follow the link below to verify your email address.',
        [
            'username' => Html::encode($user->username),
            'appname' => Yii::$app->name,
        ]
    )
?>
<?= $verificationLink ?>