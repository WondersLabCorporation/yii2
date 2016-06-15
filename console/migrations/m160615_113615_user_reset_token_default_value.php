<?php

use yii\db\Migration;

class m160615_113615_user_reset_token_default_value extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%user}}', 'verification_token', $this->string()->after('password_reset_token'));
    }

    public function down()
    {
        $this->alterColumn('{{%user}}', 'verification_token', $this->string()->notNull()->after('password_reset_token'));
    }
}
