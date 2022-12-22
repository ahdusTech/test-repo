<?php

class m000017_000000_create_sale_table extends CDbMigration
{
	public function up()
	{
	       $this->createTable(
			'tbl_sale',
			array(  
				'id' => 'pk',
				'domain' => 'integer NOT NULL REFERENCES tbl_domain (id)',
				'buyer' => 'integer NOT NULL REFERENCES usr_users (id)',
				'price' => 'integer',
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
			'tbl_sale'
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
