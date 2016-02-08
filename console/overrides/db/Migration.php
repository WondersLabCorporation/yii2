<?php

namespace console\overrides\db;

class Migration extends \yii\db\Migration
{
    /**
     * SQL driver-related table options
     * @var null|string
     */
    public $tableOptions = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    }
}
