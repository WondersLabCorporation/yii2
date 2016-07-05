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
                'slug',
                'type',
                'items_amount',
                'editor_type',
                'is_image_required',
                'status',
                'created_at',
                'updated_at',
            ],
            [
                [
                    StaticType::ID_PAGE,
                    'Page',
                    'page',
                    StaticType::TYPE_PAGE,
                    StaticType::AMOUNT_UNLIMITED,
                    StaticType::EDITOR_TYPE_WYSIWYG,
                    true,
                    StaticType::STATUS_ACTIVE,
                    $currentTime,
                    $currentTime,
                ],
                [
                    StaticType::ID_CONTACTUS_BLOCK,
                    'Contact Us Block',
                    'contact-us-block',
                    StaticType::TYPE_PAGE_BLOCK,
                    StaticType::AMOUNT_UNLIMITED,
                    StaticType::EDITOR_TYPE_WYSIWYG,
                    false,
                    StaticType::STATUS_ACTIVE,
                    $currentTime,
                    $currentTime,
                ],
                [
                    StaticType::ID_MAINCTA_BLOCK,
                    'Main CTA Block',
                    'main-cta-block',
                    StaticType::TYPE_PAGE_BLOCK,
                    1,
                    StaticType::EDITOR_TYPE_WYSIWYG,
                    true,
                    StaticType::STATUS_ACTIVE,
                    $currentTime,
                    $currentTime,
                ],
                [
                    StaticType::ID_SECONDARYCTA_BLOCK,
                    'Secondary CTA Block',
                    'secondary-cta-block',
                    StaticType::TYPE_PAGE_BLOCK,
                    1,
                    StaticType::EDITOR_TYPE_WYSIWYG,
                    false,
                    StaticType::STATUS_ACTIVE,
                    $currentTime,
                    $currentTime,
                ],
                [
                    StaticType::ID_HOME_BLOCK,
                    'Home Page Block',
                    'home-page-block',
                    StaticType::TYPE_PAGE_BLOCK,
                    StaticType::AMOUNT_UNLIMITED,
                    StaticType::EDITOR_TYPE_WYSIWYG,
                    false,
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
