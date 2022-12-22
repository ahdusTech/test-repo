<?php

class m000010_000000_add_invoicing_columns extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'usr_users',
			'street',
			'string'
		);
		$this->addColumn(
			'usr_users',
			'zipcode',
			'string'
		);
		$this->addColumn(
			'usr_users',
			'city',
			'string'
		);
		$this->addColumn(
			'usr_users',
			'country',
			'string'
		);
		$this->addColumn(
			'usr_users',
			'vat_id',
			'string'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'usr_users',
			'vat_id'
		);
		$this->dropColumn(
			'usr_users',
			'country'
		);
		$this->dropColumn(
			'usr_users',
			'city'
		);
		$this->dropColumn(
			'usr_users',
			'zipcode'
		);
		$this->dropColumn(
			'usr_users',
			'street'
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
