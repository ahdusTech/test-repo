<?php

class m100003_000000_create_mail_template_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'tbl_mail_template',
			array(
				'id' => 'pk',
				'title' => 'string',
				'content' => 'text',
				"UNIQUE (title)",
			),
			(
				$this->dbConnection->getSchema(
				) instanceof CMysqlSchema
			) ? 'ENGINE=InnoDB' : ''
		);
	}

	public function down()
	{
		$this->dropTable(
			'tbl_mail_template'
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
