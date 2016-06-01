<?php
namespace frontend\models;

use Yii;
use yii\helpers\Html;

/**
 * Login form
 */
class LoginForm extends \common\models\LoginForm
{
    public $userClass = 'frontend\models\User';
}
