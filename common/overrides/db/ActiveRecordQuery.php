<?php

namespace common\overrides\db;

/**
 * This is the ActiveQuery class for [[ActiveRecord]].
 *
 * @see StaticPage
 */
class ActiveRecordQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        // TODO: Find out how to use current Model class instead of global ActiveRecord
        $this->andWhere(['status' => ActiveRecord::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return ActiveRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ActiveRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}