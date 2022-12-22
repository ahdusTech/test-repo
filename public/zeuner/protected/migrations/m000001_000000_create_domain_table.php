<?php

class m000001_000000_create_domain_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'tbl_domain',
			array(
				'id' => 'pk',
				'name' => 'string NOT NULL',
				'auction' => 'boolean'
			)
		);
	}

	public function down()
	{
		$this->dropTable(
			'tbl_domain'
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
