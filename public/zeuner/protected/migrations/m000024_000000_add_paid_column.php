<?php

class m000024_000000_add_paid_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_sale',
			'paid',
			'boolean'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_sale',
			'paid'
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
