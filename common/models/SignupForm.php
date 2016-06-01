<?php
namespace common\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    
    public $userClass = 'common\models\User';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => $this->userClass, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 50],
            ['username', 'match', 'pattern' => '/^[^@]*$/i', 'message' => 'Username should not contain @ symbol.'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => $this->userClass, 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new $this->userClass();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                Yii::$app->mailer
                    ->compose(
                        [
                            'html' => 'successfulRegistration-html',
                            'text' => 'successfulRegistration-text'
                        ],
                        [
                            'user' => $user,
                            'verificationLink' => \yii\helpers\Url::to(
                                [
                                    'site/verify-email',
                                    'token' => $user->verification_token
                                ],
                                true
                            ),
                        ]
                    )
                    ->setFrom([Yii::$app->params['noreplyEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($user->email)
                    ->setSubject('Successful registration on ' . Yii::$app->name)
                    ->send();
                return $user;
            }
        }

        return null;
    }
}
