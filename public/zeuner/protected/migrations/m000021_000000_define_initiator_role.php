<?php

Yii::import(
	'protected.components.*'
);

class m000021_000000_define_initiator_role extends CDbMigration
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
		$auth->createRole(
			'initiator',
			'user who can start the auction',
			'return Yii::app()->user->id === $params["domain"]->initiator;'
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
		$auth->removeAuthItem(
			'initiator'
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
