<?php

class m100014_000000_add_domain_cpc_override_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_domain',
			'cpc_override',
			'integer DEFAULT -1'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_domain',
			'cpc_override'
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
