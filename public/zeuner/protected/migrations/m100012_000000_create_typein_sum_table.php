<?php

class m100012_000000_create_typein_sum_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'tbl_typein_sums',
			array(
				'domain' => 'integer NOT NULL REFERENCES tbl_domain (id)',
				'days' => 'integer',
				'accesses' => 'integer',
				'counted_on' => 'timestamp NOT NULL',
				"PRIMARY KEY (domain)",
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
			'tbl_typein_sums'
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
