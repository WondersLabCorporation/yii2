<?php
namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use common\overrides\db\ActiveRecord;

/**
 * @inheritdoc
 */
class User extends \common\models\User
{
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                // User (non-admin) accounts allowed on frontend only
                ['role', 'in', 'range' => [self::ROLE_USER], 'when' => function ($model) {
                    return $this->isAttributeChanged('role');
                }],
            ]
        );
    }
}
