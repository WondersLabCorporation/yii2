<?php

namespace backend\models;

/**
 * @inheritdoc
 */
class StaticContent extends \common\models\StaticContent
{
    public $namespace = 'backend\models';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // type_id massive assignment is prohibited since it is not allowed to change type for existing content item
        $scenarios[self::SCENARIO_DEFAULT][] = '!type_id';
        return $scenarios;
    }
}
