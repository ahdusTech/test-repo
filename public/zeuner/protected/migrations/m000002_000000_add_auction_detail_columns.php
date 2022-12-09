<?php

class m000002_000000_add_auction_detail_columns extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_domain',
			'auction_begin',
			'date'
		);
		$this->addColumn(
			'tbl_domain',
			'auction_start_price',
			'integer'
		);
		$this->addColumn(
			'tbl_domain',
			'auction_price_step',
			'integer'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_domain',
			'auction_price_step'
		);
		$this->dropColumn(
			'tbl_domain',
			'auction_start_price'
		);
		$this->dropColumn(
			'tbl_domain',
			'auction_begin'
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
