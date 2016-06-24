<?php

namespace common\overrides\gii\model;

/**
 * @inheritdoc
 */
class Generator extends \yii\gii\generators\model\Generator
{
    public $ns = 'common\models';
    public $baseClass = 'common\overrides\db\ActiveRecord';
    public $useTablePrefix = true;
    /**
     * @inheritdoc
     */
    public $enableI18N = true;
    /**
     * @inheritdoc
     */
    public $messageCategory = 'common';
    
    public $name = 'Common Model Generator';
    public $description = 'This generator generates an ActiveRecord class for the specified database table in common folder.';


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->description;
    }
}
