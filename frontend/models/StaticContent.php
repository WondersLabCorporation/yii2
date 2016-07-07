<?php

namespace frontend\models;

/**
 * @inheritdoc
 */
class StaticContent extends \common\models\StaticContent
{
    public $namespace = 'frontend\models';

    /**
     * @inheritdoc
     * returns only active items
     */
    public static function findAllByTypeId($type_id)
    {
        // TODO: Same issue as in parent. Refactor this once TODO in parent is resolved
        return self::find()->joinWith('type')->andWhere([StaticType::tableName() . '.id' => $type_id, StaticType::tableName() . '.status' => StaticType::STATUS_ACTIVE])->active()->all();
    }

    /**
     * @inheritdoc
     * returns only active items
     */
    public static function findOneByTypeId($type_id)
    {
        // TODO: Same issue as in parent. Refactor this once TODO in parent is resolved
        return self::find()->joinWith('type')->andWhere([StaticType::tableName() . '.id' => $type_id, StaticType::tableName() . '.status' => StaticType::STATUS_ACTIVE])->active()->limit(1)->one();
    }
}
