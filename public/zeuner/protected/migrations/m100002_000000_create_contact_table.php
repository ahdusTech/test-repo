<?php

class m100002_000000_create_contact_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'tbl_contact_data',
			array(
				'id' => 'pk',
				'domain' => 'integer NOT NULL REFERENCES tbl_domain (id)',
				'name' => 'string',
				'email' => 'string',
				'contacted_on' => 'timestamp NOT NULL',
				"UNIQUE (domain,email)",
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
			'tbl_contact_data'
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
