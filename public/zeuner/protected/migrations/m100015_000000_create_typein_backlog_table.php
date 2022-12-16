<?php

class m100015_000000_create_typein_backlog_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'tbl_typein_backlog',
			array(
				'domain' => 'integer NOT NULL REFERENCES tbl_domain (id)',
				'aggregated_on' => 'timestamp NOT NULL',
				"PRIMARY KEY (domain)",
			),
			(
				$this->dbConnection->getSchema(
				) instanceof CMysqlSchema
			) ? 'ENGINE=InnoDB' : ''
		);
		for (
			$backlog = 0;
			10 > $backlog;
			$backlog++
		) {
			$this->addColumn(
				'tbl_typein_backlog',
				"backlog$backlog",
				'integer'
			);
		}
	}

	public function down()
	{
		$this->dropTable(
			'tbl_typein_backlog'
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
