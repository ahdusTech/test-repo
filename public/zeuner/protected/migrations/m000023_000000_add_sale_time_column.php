<?php

class m000023_000000_add_sale_time_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_sale',
			'sold_at',
			'timestamp'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_sale',
			'sold_at'
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
