<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%static_type}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $items_amount
 * @property integer $editor_type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property StaticContent[] $contentItems
 */
class StaticType extends \common\overrides\db\ActiveRecord
{
    public $namespace = 'common\models';
    
    const ID_PAGE = 1;
    const ID_CONTACTUS_BLOCK = 2;
    const ID_MAINCTA_BLOCK = 3;
    const ID_SECONDARYCTA_BLOCK = 4;
    const ID_HOME_BLOCK = 5;

    // TODO: Need to re-think this solution. Does not look as a good idea
    const EDITOR_TYPE_WYSIWYG = 1;
    const EDITOR_TYPE_TEXTAREA = 2;
    const EDITOR_TYPE_TEXTINPUT = 3;

    /**
     * Page type requires title, content and slug to access the page
     */
    const TYPE_PAGE = 1;
    /**
     * Page block requires content and (maybe) title
     */
    const TYPE_PAGE_BLOCK = 2;

    /**
     * Unlimited amount value
     */
    const AMOUNT_UNLIMITED = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%static_type}}';
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'slug' => [
                    'class' => SluggableBehavior::className(),
                    'attribute' => 'name',
                    'ensureUnique' => true,
                    'immutable' => true,
                ],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [['name'], 'required'],
                [['type', 'items_amount', 'editor_type', 'status', 'created_at', 'updated_at'], 'integer'],
                [['name'], 'string', 'max' => 255],
                ['editor_type', 'in', 'range' => [self::EDITOR_TYPE_TEXTAREA, self::EDITOR_TYPE_TEXTINPUT, self::EDITOR_TYPE_WYSIWYG]],
                ['type', 'in', 'range' => [self::TYPE_PAGE, self::TYPE_PAGE_BLOCK]],
                ['type', 'default', 'value' => self::TYPE_PAGE],
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
                'name' => Yii::t('common', 'Name'),
                'slug' => Yii::t('common', 'Slug'),
                'type' => Yii::t('common', 'Type'),
                'items_amount' => Yii::t('common', 'Items Amount'),
                'editor_type' => Yii::t('common', 'Editor Type'),
                'status' => Yii::t('common', 'Status'),
                'created_at' => Yii::t('common', 'Created At'),
                'updated_at' => Yii::t('common', 'Updated At'),

                'typeText' => Yii::t('common', 'Type'),
                'editorTypeText' => Yii::t('common', 'Editor Type'),
                'itemsAmountText' => Yii::t('common', 'Items Amount'),
            ]
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentItems()
    {
        return $this->hasMany($this->getCurrentNamespace('StaticContent'), ['type_id' => 'id']);
    }

    /**
     * @return bool Whether Slug is required for this type or not
     */
    public function isSlugRequired()
    {
        return $this->type == self::TYPE_PAGE;
    }
    
    public static function getTypeTexts()
    {
        return [
            self::TYPE_PAGE => Yii::t('common', 'Page'),
            self::TYPE_PAGE_BLOCK => Yii::t('common', 'Block'),
        ];
    }
    
    public function getTypeText()
    {
        return $this->getListAttributeText('type');
    }

    public static function getEditorTypeTexts()
    {
        return [
            self::EDITOR_TYPE_WYSIWYG => Yii::t('common', 'WYSIWYG'),
            self::EDITOR_TYPE_TEXTAREA => Yii::t('common', 'Text Area'),
            self::EDITOR_TYPE_TEXTINPUT => Yii::t('common', 'Text Input'),
        ];
    }

    public function getEditorTypeText()
    {
        return $this->getListAttributeText('editor_type');
    }

    public function getItemsAmountText()
    {
        return ($this->items_amount == self::AMOUNT_UNLIMITED) ? Yii::t('common', 'Unlimited') : $this->items_amount;
    }
    
    public function isItemsAmountUnlimitedText()
    {
        return is_string($this->items_amount) && strtolower($this->items_amount) == 'unlimited';
    }
    
    public static function activeItemsList()
    {
        // TODO: Add caching
        return self::find()->active()->asArray()->indexBy('id')->all();
    }
}
