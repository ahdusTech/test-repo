<?php

Yii::import(
	'protected.components.*'
);

class m000016_000000_assign_admin_role extends CDbMigration
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
			'admin'
		);
		$auth->assign(
			'admin',
			UserIdentity::find(
				array(
					'username' => 'admin',
				)
			)->getId(
			)
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
		$auth->revoke(
			'admin',
			UserIdentity::find(
				array(
					'username' => 'admin',
				)
			)->getId(
			)
		);
		$auth->removeAuthItem(
			'admin'
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
