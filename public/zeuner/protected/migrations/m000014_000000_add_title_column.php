<?php

class m000014_000000_add_title_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'usr_users',
			'title',
			'string'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'usr_users',
			'title'
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
