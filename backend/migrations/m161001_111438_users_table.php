<?php

use yii\db\Migration;
use yii\db\Schema;
class m161001_111438_users_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'email'                => Schema::TYPE_STRING . '(255) NOT NULL',
            'password_hash'        => Schema::TYPE_STRING . '(60) NOT NULL',
            'auth_key'             => Schema::TYPE_STRING . '(32) NOT NULL',
            'info'                 => Schema::TYPE_STRING . '(255)',
            'token'                => Schema::TYPE_STRING . '(32)',
        ]);

        $this->createIndex('user_unique_token', '{{%user}}', 'token', true);
        $this->createIndex('user_unique_email', '{{%user}}', 'email', true);

    }

    public function down()
    {

    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
