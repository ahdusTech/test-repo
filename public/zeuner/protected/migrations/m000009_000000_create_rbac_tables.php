<?php

class m000009_000000_create_rbac_tables extends CDbMigration
{
	public function up()
	{
		//create the auth item table
		$this->createTable(
			'tbl_auth_item',
			array(
				'name' => 'string NOT NULL',
				'type' => 'integer NOT NULL',
				'description' => 'text',
				'bizrule' => 'text',
				'data' => 'text',
				"PRIMARY KEY (name)",
			),
			(
				$this->dbConnection->getSchema(
				) instanceof CMysqlSchema
			) ? 'ENGINE=InnoDB' : ''
		);

		//create the auth item child table
		$this->createTable(
			'tbl_auth_item_child',
			array(
				'parent' => 'string NOT NULL REFERENCES tbl_auth_item (name)',
				'child' => 'string NOT NULL REFERENCES tbl_auth_item (name)',
				"PRIMARY KEY (parent,child)",
			),
			(
				$this->dbConnection->getSchema(
				) instanceof CMysqlSchema
			) ? 'ENGINE=InnoDB' : ''
		);

		//create the auth assignment table
		$this->createTable(
			'tbl_auth_assignment',
			array(
				'itemname' => 'string NOT NULL REFERENCES tbl_auth_item (name)',
				'userid' => 'integer NOT NULL REFERENCES usr_users (id)',
				'bizrule' => 'text',
				'data' => 'text',
				"PRIMARY KEY (itemname,userid)",
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
			'tbl_auth_assignment'
		);
		$this->dropTable(
			'tbl_auth_item_child'
		);
		$this->dropTable(
			'tbl_auth_item'
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
