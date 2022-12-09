<?php

class m000020_000000_add_sale_column_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_domain',
			'sold',
			'integer REFERENCES tbl_sale(id)'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_domain',
			'sold'
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
