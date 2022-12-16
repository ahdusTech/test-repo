<?php

class m100011_000000_create_cpc_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'tbl_keyword_cpc',
			array(
				'keyword' => 'string',
				'cents' => 'integer',
				"PRIMARY KEY (keyword)",
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
			'tbl_keyword_cpc'
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
