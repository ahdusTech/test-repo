<?php

class m000007_000000_create_table_user_profile_pictures extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('usr_user_profile_pictures', array(
            'id' => 'pk',
            'user_id' => 'integer NOT NULL REFERENCES usr_users (id) ON UPDATE CASCADE ON DELETE CASCADE',
            'original_picture_id' => 'integer REFERENCES usr_user_profile_pictures (id) ON UPDATE CASCADE ON DELETE CASCADE',
            'filename' => 'string NOT NULL',
            'width' => 'integer NOT NULL',
            'height' => 'integer NOT NULL',
            'mimetype' => 'string NOT NULL',
            'created_on' => 'timestamp NOT NULL',
            'contents' => 'text NOT NULL',
        ));
        $this->createIndex('usr_user_profile_pictures_user_id_idx', 'usr_user_profile_pictures', 'user_id');
        $this->createIndex('usr_user_profile_pictures_original_picture_id_idx', 'usr_user_profile_pictures', 'original_picture_id');
        $this->createIndex('usr_user_profile_pictures_width_height_idx', 'usr_user_profile_pictures', 'width, height');
    }

    public function safeDown()
    {
        $this->dropTable('usr_user_profile_pictures');
    }
}
