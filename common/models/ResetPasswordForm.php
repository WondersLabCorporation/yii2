<?php
namespace common\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $token;

    /**
     * @var \common\models\User
     */
    protected $_user;

    public $userClass = 'common\models\User';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'token'], 'required'],
            // TODO: Use global password validator
            ['password', 'string', 'min' => 6],
            ['token', 'string'],
            ['token', 'validateToken'],
        ];
    }
    
    public function validateToken()
    {
        if (!$this->getUser()) {
            $this->addError('token', 'Wrong password reset token.');
        }
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }

    protected function getUser()
    {
        /* @var $userClass User */
        $userClass = $this->userClass;
        if ($this->_user === null) {
            // We allow reset password for active and pending users since both of them come here by url from email
            $this->_user = $userClass::findByPasswordResetToken($this->token, [$userClass::STATUS_ACTIVE, $userClass::STATUS_PENDING]);
        }

        return $this->_user;
    }
}
