<?php

use common\models\StaticType;
use yii\db\Migration;

/**
 * Handles the creation for table `cms_content`.
 */
class m160630_075627_create_cms_content extends \console\overrides\db\Migration
{
    public $tableName = '{{%static_content}}';
    public $typeTableName = '{{%static_type}}';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->string()->notNull(),
            'slug' => $this->string(),
            'type_id' => $this->integer(),
            // TODO: Add image

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $this->tableOptions);

        $this->createTable($this->typeTableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type' => $this->integer()->defaultValue(StaticType::TYPE_PAGE),
            'items_amount' => $this->integer()->defaultValue(StaticType::AMOUNT_UNLIMITED),
            'editor_type' => $this->integer()->defaultValue(StaticType::EDITOR_TYPE_WYSIWYG),

            'status' => $this->smallInteger()->notNull()->defaultValue(StaticType::STATUS_ACTIVE),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $this->tableOptions);

        $this->addForeignKey('fk_cms_content__cms_type', $this->tableName, 'type_id', $this->typeTableName, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->tableName);
        $this->dropTable($this->typeTableName);
    }
}
