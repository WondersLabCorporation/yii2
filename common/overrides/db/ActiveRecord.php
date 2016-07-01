<?php
namespace common\overrides\db;

use common\overrides\db\ActiveRecordQuery;
use Yii;
use yii\behaviors\TimestampBehavior;

class ActiveRecord extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $namespace = '';

    /**
     * @param null|string $modelClass
     * @return string
     */
    public function getCurrentNamespace($modelClass = null)
    {
        if (!$modelClass || !$this->hasProperty(lcfirst($modelClass) . 'Namespace')) {
            // return root namespace
            return $this->namespace . '\\' . $modelClass;
        }
        return lcfirst($modelClass) . 'Namespace';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timeStampBehavior' => TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
                ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ]
        );
    }

    /**
     * @inheritdoc
     * @return ActiveRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActiveRecordQuery(get_called_class());
    }

    /**
     * Overrode findAll to include condition also if needed
     * @inheritdoc
     */
    public static function findAll($condition = null)
    {
        if (!empty($condition)) {
            return parent::findAll($condition);
        }

        return self::find()->all();
    }

    /**
     * List of human-readable statuses
     * @return array
     */
    public static function getStatusTexts()
    {
        return [
            static::STATUS_ACTIVE => Yii::t('app', 'Active'),
            static::STATUS_DELETED => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * Get current status human-readable value
     * @return string
     */
    public function getStatusText()
    {
        return (!empty($this->getStatusTexts()[$this->status])) ? $this->getStatusTexts()[$this->status] : '';
    }

    /**
     * Get current attribute human-readable value
     * @param $attribute string Attribute name
     * @return string
     */
    public function getListAttributeText($attribute)
    {
        // TODO: Need to find a more common solution instead of hardcoded method name
        $getListAttributeTexts = $this->generateTextsMethod($attribute);
        if (!$this->hasMethod($getListAttributeTexts) || empty($this->$getListAttributeTexts()[$this->$attribute])) {
            return null;
        }
        return $this->$getListAttributeTexts()[$this->$attribute];
    }

    protected function generateTextsMethod($attribute)
    {

        // TODO: Need to find a more common solution instead of hardcoded method name
        $result = 'get';
        $attributeParts = explode('_', $attribute);
        foreach ($attributeParts as $attributePart) {
            $result .= ucfirst($attributePart);
        }
        $result .= 'Texts';
        return $result;
    }
}
