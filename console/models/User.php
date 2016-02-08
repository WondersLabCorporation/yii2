<?php
namespace console\models;

use Yii;

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
                // Required to create admin accounts from console
                ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_ADMIN]],
            ]
        );
    }
}
