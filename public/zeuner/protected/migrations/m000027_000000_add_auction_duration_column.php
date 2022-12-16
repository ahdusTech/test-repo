<?php

class m000027_000000_add_auction_duration_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_domain',
			'auction_duration',
			'integer DEFAULT 30'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_domain',
			'auction_duration'
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
