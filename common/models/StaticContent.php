<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use sadovojav\cutter\behaviors\CutterBehavior;

/**
 * This is the model class for table "{{%static_content}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $image
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

    /**
     * @inheritdoc
     */
    public static function getStatusTexts()
    {
        $statusTexts = parent::getStatusTexts();
        $statusTexts[self::STATUS_DELETED] = Yii::t('app', 'Disabled');
        return $statusTexts;
    }
    
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'slug' => [
                    'class' => SluggableBehavior::className(),
                    'attribute' => 'title',
                    'ensureUnique' => true,
                    'immutable' => true,
                    'uniqueValidator' => [
                        // Slug should be unique among content items of the same type
                        'targetAttribute' => ['slug', 'type_id'],
                    ],
                    // TODO: Add condition to generate Slug for content with Page type only
                ],
                'image' => [
                    'class' => CutterBehavior::className(),
                    'attributes' => 'image',
                    'baseDir' => '/uploads/static',
                    'basePath' => Yii::getAlias('@frontend/web'),
                ],
                // TODO: Count behavior
            ]
        );
    }

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
                [['title', 'slug'], 'string', 'max' => 255],
                [['content'], 'string'],
                [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaticType::className(), 'targetAttribute' => ['type_id' => 'id']],
                [
                    'image',
                    'file',
                    'mimeTypes' => ['image/*'],
                ],
           ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'id' => Yii::t('common', 'ID'),
                'title' => Yii::t('common', 'Title'),
                'content' => Yii::t('common', 'Content'),
                'slug' => Yii::t('common', 'Slug'),
                'type_id' => Yii::t('common', 'Type'),
                'image' => Yii::t('app', 'Image'),
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

    /**
     * @param $type_id integer ID of the Type entity
     * @return static self instance, or null if nothing matches.
     */
    public static function findOneByTypeId($type_id)
    {
        // TODO: StaticType::tableName() will not be changed. Anyway need to find out how to set appropriate namespace for StaticType class when called from static method
        return self::find()->joinWith('type')->andWhere([StaticType::tableName() . '.id' => $type_id])->limit(1)->one();
    }

    /**
     * @return null|string Image url
     */
    public function getImageAbsoluteUrl() 
    {
        // TODO: Temporary solution. Need to find a more generic solution for all the images in any project
        if (empty($this->image)) {
            return null;
        }

        // For backend (or any other app) we create absolute Urls using frontendUrlManager if any
        if (isset(Yii::$app->components['frontendUrlManager'])) {
            return Yii::$app->frontendUrlManager->createAbsoluteUrl($this->image);
        }
        return Yii::$app->urlManager->createUrl($this->image);
    }

    public function isActive($checkTypeStatus = true)
    {
        if ($checkTypeStatus) {
            $staticTypeClass = $this->getCurrentNamespace('StaticType');
            return $this->status == self::STATUS_ACTIVE && $this->type->status == constant($staticTypeClass . '::STATUS_ACTIVE');
        }
        return $this->status == self::STATUS_ACTIVE;
    }
}
