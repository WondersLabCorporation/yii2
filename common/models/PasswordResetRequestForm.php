<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    public $userClass = 'common\models\User';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /* @var $userClass \frontend\models\User */
        $userClass = $this->userClass;

        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => $this->userClass,
                'filter' => ['status' => $userClass::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $userClass \frontend\models\User */
        $userClass = $this->userClass;

        $user = $userClass::findOne([

            'email' => $this->email,
        ]);

        if (!$user || $user->status == $userClass::STATUS_DELETED) {
            $this->addError('email', 'No such user found');
            return false;
        }


        if (!$userClass::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
        }

        if (!$user->save()) {
            Yii::error('Failed to update user password reset token. Errors: ' . json_encode($user->getErrors()), 'authorization');
            return false;
        }

        return \Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset request for ' . \Yii::$app->name)
            ->send();

    }
}
