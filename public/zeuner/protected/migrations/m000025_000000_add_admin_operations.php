<?php

Yii::import(
	'protected.components.*'
);

class m000025_000000_add_admin_operations extends CDbMigration
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
			'domains',
			'administer domains'
		);
		$auth->createOperation(
			'customers',
			'administer customers'
		);
		$admin = $auth->getAuthItem(
			'admin'
		);
		$admin->addChild(
			'domains'
		);
		$admin->addChild(
			'customers'
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
			'domains'
		);
		$admin->removeChild(
			'customers'
		);
		$auth->removeAuthItem(
			'domains'
		);
		$auth->removeAuthItem(
			'customers'
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
