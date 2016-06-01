<?php
namespace frontend\models;

/**
 * @inheritdoc
 */
class PasswordResetRequestForm extends \common\models\PasswordResetRequestForm
{
    public $userClass = 'frontend\models\User';
}
