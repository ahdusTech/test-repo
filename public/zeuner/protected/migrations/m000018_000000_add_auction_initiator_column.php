<?php

class m000018_000000_add_auction_initiator_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_domain',
			'initiator',
			'integer REFERENCES usr_users(id)'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_domain',
			'initiator'
		);
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
