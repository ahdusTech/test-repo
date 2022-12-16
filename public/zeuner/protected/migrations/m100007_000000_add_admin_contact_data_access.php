<?php

Yii::import(
	'protected.components.*'
);

class m100007_000000_add_admin_contact_data_access extends CDbMigration
{
	public function up()
	{
		$auth = Yii::app(
		)->authManager;
		if (
			$auth->db !== $this->getDbConnection(
			)
		) {
			echo "database mismatch!\n";
			return false;
		}
		$auth->createOperation(
			'contact_data',
			'access contact data'
		);
		$admin = $auth->getAuthItem(
			'admin'
		);
		$admin->addChild(
			'contact_data'
		);
		$auth->save(
		);
	}

	public function down()
	{
		$auth = Yii::app(
		)->authManager;
		if (
			$auth->db !== $this->getDbConnection(
			)
		) {
			echo "database mismatch!\n";
			return false;
		}
		$admin = $auth->getAuthItem(
			'admin'
		);
		$admin->removeChild(
			'contact_data'
		);
		$auth->removeAuthItem(
			'contact_data'
		);
		$auth->save(
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
