<?php

class m000003_000000_create_table_users extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('usr_users', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'password' => 'string NOT NULL',
            'email' => 'string NOT NULL',
            'firstname' => 'string',
            'lastname' => 'string',
            'activation_key' => 'string',
            'created_on' => 'timestamp',
            'updated_on' => 'timestamp',
            'last_visit_on' => 'timestamp',
            'password_set_on' => 'timestamp',
            'email_verified' => 'boolean NOT NULL DEFAULT false',
            'is_active' => 'boolean NOT NULL DEFAULT false',
            'is_disabled' => 'boolean NOT NULL DEFAULT false',
        ));
        $this->createIndex('usr_users_username_idx', 'usr_users', 'username', true);
        $this->createIndex('usr_users_email_idx', 'usr_users', 'email', true);
        $this->createIndex('usr_users_email_verified_idx', 'usr_users', 'email_verified');
        $this->createIndex('usr_users_is_active_idx', 'usr_users', 'is_active');
        $this->createIndex('usr_users_is_disabled_idx', 'usr_users', 'is_disabled');
    }

    public function safeDown()
    {
        $this->dropTable('usr_users');
    }
}
