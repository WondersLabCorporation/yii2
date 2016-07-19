<?php

namespace common\validators;

use Yii;
use yii\db\ActiveRecordInterface;
use yii\validators\UniqueValidator;

/**
 * @inheritdoc
 * Overriding Unique validator to check variable amount of items (not just one)
 * Changes are marked with "CHANGE:" comment
 */
class CountValidator extends UniqueValidator
{
    /**
     * @var integer Maximum number of items
     */
    public $limit;


    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->message === null) {
            // CHANGE: Changing default error message to fit current validator
            $this->message = Yii::t('yii', 'You have reached the limit for the number of items with the current {attribute}.');
        }
        parent::init();
    }

    /**
     * @inheritdoc
     * Copy-paste of the UniqueValidator with few changes
     */
    public function validateAttribute($model, $attribute)
    {
        /* @var $targetClass ActiveRecordInterface */
        $targetClass = $this->targetClass === null ? get_class($model) : $this->targetClass;
        $targetAttribute = $this->targetAttribute === null ? $attribute : $this->targetAttribute;

        if (is_array($targetAttribute)) {
            $params = [];
            foreach ($targetAttribute as $k => $v) {
                $params[$v] = is_int($k) ? $model->$v : $model->$k;
            }
        } else {
            $params = [$targetAttribute => $model->$attribute];
        }

        foreach ($params as $value) {
            if (is_array($value)) {
                $this->addError($model, $attribute, Yii::t('yii', '{attribute} is invalid.'));

                return;
            }
        }

        $query = $targetClass::find();
        $query->andWhere($params);

        if ($this->filter instanceof \Closure) {
            call_user_func($this->filter, $query);
        } elseif ($this->filter !== null) {
            $query->andWhere($this->filter);
        }

        if (!$model instanceof ActiveRecordInterface || $model->getIsNewRecord() || $model->className() !== $targetClass::className()) {
            // if current $model isn't in the database yet then it's OK just to call exists()
            // also there's no need to run check based on primary keys, when $targetClass is not the same as $model's class
            // CHANGE: Executing count() instead of exist
            $exists = $query->count() >= $this->limit;
        } else {
            // if current $model is in the database already we can't use exists()
            /* @var $models ActiveRecordInterface[] */
            // CHANGE: limiting to the requested count + 1 to since current item
            $models = $query->limit($this->limit + 1)->all();
            $n = count($models);
            if ($n === $this->limit) {
                $keys = array_keys($params);
                $pks = $targetClass::primaryKey();
                sort($keys);
                sort($pks);
                if ($keys === $pks) {
                    // primary key is modified and not unique
                    $exists = $model->getOldPrimaryKey() != $model->getPrimaryKey();
                } else {
                    // non-primary key, need to exclude the current record based on PK
                    // CHANGE: When found amount is the same as the limit. Assuming that we are NOT editing one of those items
                    $exists = true;
                    foreach ($models as $model) {
                        // CHANGE: If we are editing one of those items - validation is successful
                        if ($model->getPrimaryKey() == $model->getOldPrimaryKey()) {
                            $exists = false;
                            break;
                        }
                    }

                }
            } else {
                $exists = $n > $this->limit;
            }
        }

        if ($exists) {
            $this->addError($model, $attribute, $this->message);
        }
    }
}
