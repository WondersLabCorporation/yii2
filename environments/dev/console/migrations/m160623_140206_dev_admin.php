<?php

use console\models\User;
use yii\db\Migration;

class m160623_140206_dev_admin extends Migration
{
    protected $tableName = '{{%user}}';

    public function up()
    {
        $this->insert($this->tableName, [
            'username' => 'WondersLab Developer',
            'email' => 'developer@wonderslab.com',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
            'password_hash' => Yii::$app->security->generatePasswordHash('TDd3r?6W8$'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function down()
    {
        $this->delete($this->tableName, [
            'email' => 'developer@wonderslab.com',
        ]);
    }
}
