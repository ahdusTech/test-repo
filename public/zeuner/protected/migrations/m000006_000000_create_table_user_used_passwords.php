<?php

class m000006_000000_create_table_user_used_passwords extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('usr_user_used_passwords', array(
            'id' => 'pk',
            'user_id' => 'integer NOT NULL REFERENCES usr_users (id) ON UPDATE CASCADE ON DELETE CASCADE',
            'password' => 'string NOT NULL',
            'set_on' => 'timestamp NOT NULL',
        ));
        $this->createIndex('usr_user_used_passwords_user_id_idx', 'usr_user_used_passwords', 'user_id');
    }

    public function safeDown()
    {
        $this->dropTable('usr_user_used_passwords');
    }
}
