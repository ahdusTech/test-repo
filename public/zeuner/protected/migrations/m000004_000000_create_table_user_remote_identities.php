<?php

class m000004_000000_create_table_user_remote_identities extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('usr_user_remote_identities', array(
            'id' => 'pk',
            'user_id' => 'integer NOT NULL REFERENCES usr_users (id) ON UPDATE CASCADE ON DELETE CASCADE',
            'provider' => 'varchar(100) NOT NULL',
            'identifier' => 'varchar(100) NOT NULL',
            'created_on' => 'timestamp NOT NULL',
            'last_used_on' => 'timestamp',
        ));
        $this->createIndex('usr_user_remote_identities_provider_identifier_idx', 'usr_user_remote_identities', 'provider, identifier', true);
        $this->createIndex('usr_user_remote_identities_user_id_idx', 'usr_user_remote_identities', 'user_id');
    }

    public function safeDown()
    {
        $this->dropTable('usr_user_remote_identities');
    }
}
