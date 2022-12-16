<?php

class m000013_000000_add_company_name_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'usr_users',
			'company_name',
			'string'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'usr_users',
			'company_name'
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
