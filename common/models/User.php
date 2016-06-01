<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use common\overrides\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN = 30;
    const ROLE_USER = 10;

    const STATUS_PENDING = 1;

    public $namespace = 'common\models';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verification_token' => [
                    'class' => AttributeBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => 'verification_token',
                    ],
                    'value' => function() {
                        return Yii::$app->security->generateRandomString();
                    },
                ],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // TODO: Add appropriate rules
            ['status', 'default', 'value' => self::STATUS_PENDING],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_PENDING]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    /**
     * Finds user by username
     *
     * @param string $login
     * @param integer $status
     * @return static|null
     */
    public static function findByLogin($login, $status = null)
    {
        $userQuery = static::find()->andWhere(['or', ['username' => $login], ['email' => $login]]);
        if ($status) {
            $userQuery->andWhere(['status' => $status]);
        }
        return $userQuery->limit(1)->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token, $status = self::STATUS_ACTIVE)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        $userQuery = static::find()->andWhere(['password_reset_token' => $token]);
        $userQuery->andFilterWhere(['status' => $status]);
        return $userQuery->limit(1)->one();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public static function getStatusTexts()
    {
        $statusTexts = parent::getStatusTexts();
        $statusTexts[static::STATUS_PENDING] = Yii::t('app', 'Pending');
        return $statusTexts;
    }

    /**
     * @param $verification_token
     * @param $status
     * @return null|User Referral
     */
    public static function findByVerificationToken($verification_token,  $status = self::STATUS_PENDING)
    {
        $userQuery = static::find()->andWhere(['verification_token' => $verification_token]);
        $userQuery->andFilterWhere(['status' => $status]);
        return $userQuery->limit(1)->one();
    }

    /**
     * Activate user
     *
     * @param bool $validate
     * @return bool
     */
    public function activate($validate = true)
    {
        $this->status = static::STATUS_ACTIVE;
        return $this->save($validate);
    }

    /**
     * @param bool $resend
     * @return bool If mail send was successful
     */
    public function sendVerificationEmail($resend = false)
    {
        // TODO: add processing in case of resend (e.g. change subject)
        return Yii::$app->mailer
            ->compose(
                [
                    'html' => 'resendVerification-html',
                    'text' => 'resendVerification-text'
                ],
                ['user' => $this]
            )
            ->setFrom([Yii::$app->params['noreplyEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Email verification on ' . Yii::$app->name)
            ->send();
    }
}
