<?php

class m100009_000000_add_domain_contact_tab_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_domain',
			'contact_tab_enabled',
			'boolean'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_domain',
			'contact_tab_enabled'
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
