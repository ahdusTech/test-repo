<?php

class m100006_000000_create_typein_stats_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'tbl_typein_stats',
			array(
				'domain' => 'integer NOT NULL REFERENCES tbl_domain (id)',
				'access_date' => 'date',
				'accesses' => 'integer',
				'counted_on' => 'timestamp NOT NULL',
				"PRIMARY KEY (domain,access_date)",
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
			'tbl_typein_stats'
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
