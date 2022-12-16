<?php

Yii::import(
	'protected.components.*'
);

class m000029_000000_add_system_admin_operation extends CDbMigration
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
			'system',
			'system configuration'
		);
		$admin = $auth->getAuthItem(
			'admin'
		);
		$admin->addChild(
			'system'
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
			'system'
		);
		$auth->removeAuthItem(
			'system'
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
