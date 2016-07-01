<?php

namespace backend\models;

use Yii;

/**
 * @inheritdoc
 */
class StaticType extends \common\models\StaticType
{
    public $namespace = 'backend\models';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // Type massive assignment is prohibited since it is not allowed to change type or create something else than 'Page' from the Admin panel
        $scenarios[self::SCENARIO_DEFAULT][] = '!type';
        return $scenarios;
    }
}
