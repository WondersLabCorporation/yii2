<?php
namespace backend\models;

use Yii;

/**
 * @inheritdoc
 */
class User extends \common\models\User
{
    public $namespace = 'backend\models';
    
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_ADMIN]],
            ]
        );
    }
}
