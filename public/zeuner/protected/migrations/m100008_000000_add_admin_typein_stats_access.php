<?php

Yii::import(
	'protected.components.*'
);

class m100008_000000_add_admin_typein_stats_access extends CDbMigration
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
			'typein_stats',
			'access typein_stats'
		);
		$admin = $auth->getAuthItem(
			'admin'
		);
		$admin->addChild(
			'typein_stats'
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
			'typein_stats'
		);
		$auth->removeAuthItem(
			'typein_stats'
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
