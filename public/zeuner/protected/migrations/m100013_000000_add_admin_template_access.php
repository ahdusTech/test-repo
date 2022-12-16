<?php

Yii::import(
	'protected.components.*'
);

class m100013_000000_add_admin_template_access extends CDbMigration
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
			'mail_templates',
			'access mail templates'
		);
		$admin = $auth->getAuthItem(
			'admin'
		);
		$admin->addChild(
			'mail_templates'
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
			'mail_templates'
		);
		$auth->removeAuthItem(
			'mail_templates'
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
