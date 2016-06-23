<?php

use yii\db\Migration;

class m160615_113615_user_reset_token_default_value extends Migration
{
    protected $tableName = '{{%user}}';

    public function up()
    {
        $this->alterColumn($this->tableName, 'verification_token', $this->string()->after('password_reset_token'));
    }

    public function down()
    {
        $this->delete($this->tableName, ['verification_token' => null]);
        $this->alterColumn($this->tableName, 'verification_token', $this->string()->notNull()->after('password_reset_token'));
    }
}
