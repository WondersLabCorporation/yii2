<?php
namespace frontend\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends \common\models\ResetPasswordForm
{
    public $userClass = 'frontend\models\User';
}
