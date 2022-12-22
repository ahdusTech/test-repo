<?php

class m000012_000000_add_sms_verification_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'usr_users',
			'sms_verification_required',
			'boolean'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'usr_users',
			'sms_verification_required'
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
