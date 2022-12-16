<?php

class m100004_000000_add_mail_template_timestamp extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_mail_template',
			'last_change',
			'integer'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_mail_template',
			'last_change'
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
