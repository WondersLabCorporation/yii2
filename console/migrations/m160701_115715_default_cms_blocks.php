<?php

use common\models\StaticType;
use yii\db\Migration;

class m160701_115715_default_cms_blocks extends Migration
{
    public $typeTableName = '{{%static_type}}';
    
    public function up()
    {
        $currentTime = time();
        $this->batchInsert(
            $this->typeTableName,
            [
                'id',
                'name',
                'type',
                'items_amount',
                'editor_type',
                'status',
                'created_at',
                'updated_at',
            ],
            [
                [
                    StaticType::ID_PAGE,
                    'Page',
                    StaticType::TYPE_PAGE,
                    StaticType::AMOUNT_UNLIMITED,
                    StaticType::EDITOR_TYPE_WYSIWYG,
                    StaticType::STATUS_ACTIVE,
                    $currentTime,
                    $currentTime,
                ],
                [
                    StaticType::ID_CONTACTUS_BLOCK,
                    'Contact Us Block',
                    StaticType::TYPE_PAGE_BLOCK,
                    StaticType::AMOUNT_UNLIMITED,
                    StaticType::EDITOR_TYPE_WYSIWYG,
                    StaticType::STATUS_ACTIVE,
                    $currentTime,
                    $currentTime,
                ],
                [
                    StaticType::ID_MAINCTA_BLOCK,
                    'Main CTA Block',
                    StaticType::TYPE_PAGE_BLOCK,
                    1,
                    StaticType::EDITOR_TYPE_WYSIWYG,
                    StaticType::STATUS_ACTIVE,
                    $currentTime,
                    $currentTime,
                ],
                [
                    StaticType::ID_SECONDARYCTA_BLOCK,
                    'Secondary CTA Block',
                    StaticType::TYPE_PAGE_BLOCK,
                    1,
                    StaticType::EDITOR_TYPE_WYSIWYG,
                    StaticType::STATUS_ACTIVE,
                    $currentTime,
                    $currentTime,
                ],
                [
                    StaticType::ID_HOME_BLOCK,
                    'Home Page Block',
                    StaticType::TYPE_PAGE_BLOCK,
                    1,
                    StaticType::EDITOR_TYPE_WYSIWYG,
                    StaticType::STATUS_ACTIVE,
                    $currentTime,
                    $currentTime,
                ],
            ]
        );
    }

    public function down()
    {
        $this->delete(
            $this->typeTableName,
            [
                'id' => [
                    StaticType::ID_CONTACTUS_BLOCK,
                    StaticType::ID_HOME_BLOCK,
                    StaticType::ID_MAINCTA_BLOCK,
                    StaticType::ID_PAGE,
                    StaticType::ID_SECONDARYCTA_BLOCK
                ]
            ]
        );
    }
}
