<?php

use yii\db\Migration;

class m160524_093744_user_email_verification extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'verification_token', $this->string()->notNull()->after('password_reset_token'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'verification_token');
    }
}
