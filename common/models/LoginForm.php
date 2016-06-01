<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    public $useFlashMessages = true;

    public $resendVerificationUrl;

    protected $_user;

    public $userClass = 'common\models\User';


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // login and password are both required
            [['login', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => Yii::t('common', 'Username or Email'),
            'password' => Yii::t('common', 'Password'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect login or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided login and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user->status == constant($this->userClass . '::STATUS_PENDING')) {
                if ($this->useFlashMessages) {
                    Yii::$app->session->addFlash(
                        'warning',
                        Yii::t(
                            'authorization',
                            'You have not verified your email address yet. Please follow the verification link sent to your email address. {0}',
                            [
                                Html::a(Yii::t('authorization', 'Resend?'), ($this->resendVerificationUrl) ? $this->resendVerificationUrl : ['site/resend-verification', 'id' => $user->id]),
                            ]
                        )
                    );
                } else {
                    $this->addError(
                        'login',
                        Yii::t('authorization', 'You have not verified your email address yet.')
                    );
                }
                return false;
            }
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[login]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = call_user_func([$this->userClass, 'findByLogin'], $this->login);
        }

        return $this->_user;
    }
}
