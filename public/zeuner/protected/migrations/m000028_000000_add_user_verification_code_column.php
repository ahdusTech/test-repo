<?php

class m000028_000000_add_user_verification_code_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'usr_users',
			'verification_code',
			'string'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'usr_users',
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
