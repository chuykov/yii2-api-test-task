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
        ]);

        $this->createIndex('user_unique_email', 'user', 'email', true);
        $this->createTable('token', [
            'user_id'                => Schema::TYPE_INTEGER . ' PRIMARY KEY',
            'token'                 => Schema::TYPE_STRING . '(32) NOT NULL',
        ]);
        $this->addForeignKey('fk_user_token', 'token', 'user_id', 'user', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('token_unique_token', 'token', 'token', true);
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
