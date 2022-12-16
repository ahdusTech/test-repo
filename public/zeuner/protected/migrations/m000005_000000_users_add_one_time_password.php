<?php

class m000005_000000_users_add_one_time_password extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('usr_users', 'one_time_password_secret', 'string');
        $this->addColumn('usr_users', 'one_time_password_code', 'string');
        $this->addColumn('usr_users', 'one_time_password_counter', 'integer NOT NULL DEFAULT 0');
    }

    public function safeDown()
    {
        $this->dropColumn('usr_users', 'one_time_password_counter');
        $this->dropColumn('usr_users', 'one_time_password_code');
        $this->dropColumn('usr_users', 'one_time_password_secret');
    }
}
