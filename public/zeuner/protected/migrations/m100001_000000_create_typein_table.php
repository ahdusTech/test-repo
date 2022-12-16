<?php

class m100001_000000_create_typein_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'tbl_typein_domain',
			array(
				'domain' => 'integer NOT NULL REFERENCES tbl_domain (id)',
				'access_date' => 'date',
				'accessing_ip' => 'string',
				'logged_on' => 'timestamp NOT NULL',
				"PRIMARY KEY (domain,access_date,accessing_ip)",
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
			'tbl_typein_domain'
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
