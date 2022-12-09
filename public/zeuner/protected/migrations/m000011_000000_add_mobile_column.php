<?php

class m000011_000000_add_mobile_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'usr_users',
			'phone',
			'string'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'usr_users',
			'phone'
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
