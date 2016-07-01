<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%static_content}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property integer $type_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property StaticType $type
 */
class StaticContent extends \common\overrides\db\ActiveRecord
{
    public $namespace = 'common\models';
    
    // TODO: Count behavior
    // TODO: Slug behavior
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%static_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [['title', 'content'], 'required'],
                [['type_id', 'status', 'created_at', 'updated_at'], 'integer'],
                [['title', 'content', 'slug'], 'string', 'max' => 255],
                [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaticType::className(), 'targetAttribute' => ['type_id' => 'id']],
           ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(
            parent::rules(),
            [
                'id' => Yii::t('common', 'ID'),
                'title' => Yii::t('common', 'Title'),
                'content' => Yii::t('common', 'Content'),
                'slug' => Yii::t('common', 'Slug'),
                'type_id' => Yii::t('common', 'Type'),
                'status' => Yii::t('common', 'Status'),
                'created_at' => Yii::t('common', 'Created At'),
                'updated_at' => Yii::t('common', 'Updated At'),
            ]
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne($this->getCurrentNamespace('StaticType'), ['id' => 'type_id']);
    }

    /**
     * @param $type_id integer ID of the Type entity
     * @return static[] an array of self instances, or an empty array if nothing matches.
     */
    public static function findAllByTypeId($type_id)
    {
        // TODO: StaticType::tableName() will not be changed. Anyway need to find out how to set appropriate namespace for StaticType class when called from static method
        return self::find()->joinWith('type')->andWhere([StaticType::tableName() . '.id' => $type_id])->all();
    }
}
