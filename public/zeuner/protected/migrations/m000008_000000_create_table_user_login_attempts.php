<?php

class m000008_000000_create_table_user_login_attempts extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('usr_user_login_attempts', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'user_id' => 'integer REFERENCES usr_users (id) ON UPDATE CASCADE ON DELETE CASCADE',
            'performed_on' => 'timestamp NOT NULL',
            'is_successful' => 'boolean NOT NULL DEFAULT false',
            'session_id' => 'string',
            'ipv4' => 'integer',
            'user_agent' => 'string',
        ));

        $this->createIndex('usr_user_login_attempts_user_id_idx', 'usr_user_login_attempts', 'user_id');
    }

    public function safeDown()
    {
        $this->dropTable('usr_user_login_attempts');
    }
}
