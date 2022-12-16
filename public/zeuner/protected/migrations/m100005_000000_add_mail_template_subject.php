<?php

class m100005_000000_add_mail_template_subject extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
			'tbl_mail_template',
			'subject',
			'string'
		);
	}

	public function down()
	{
		$this->dropColumn(
			'tbl_mail_template',
			'subject'
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
