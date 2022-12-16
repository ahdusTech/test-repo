<?php

Yii::import(
	'protected.components.*'
);

class m000019_000000_define_buyer_role extends CDbMigration
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
			'buyer',
			'user who bought the domain',
			'return Yii::app()->user->id === $params["sale"]->buyer;'
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
			'buyer'
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
