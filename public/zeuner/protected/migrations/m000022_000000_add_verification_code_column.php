<?php

class m000022_000000_add_verification_code_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_domain',
			'verification_code',
			'string'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_domain',
			'verification_code'
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
