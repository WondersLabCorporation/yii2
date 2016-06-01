<?php
namespace backend\models;

use Yii;
use yii\helpers\Html;

/**
 * Login form
 */
class LoginForm extends \common\models\LoginForm
{
    public $userClass = 'backend\models\User';
}
