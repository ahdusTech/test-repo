<?php

Yii::import(
	'protected.models.*'
);

class m000015_000000_create_admin_user extends CDbMigration
{
	public function up()
	{
		CActiveRecord::$db = $this->getDbConnection(
		);
		$record = new User;
		$record->username = 'admin';
		$record->password_plain = 'crijbiawn-';
		$record->password_again = $record->password_plain;
		$record->email = 'harald.hochmann@day.eu';
		$record->is_active = 1;
		$record->is_disabled = 0;
		$record->sms_verification_required = 0;
		$record->email_verified = 0;
		$record->phone = "+491631758373";
		$record->terms_agreed = 1;
		$record->title = "Herr";
		$record->firstname = "Harald";
		$record->lastname = "Hochmann";
		$record->street = "Handelskai 94-96";
		$record->zipcode = "1200";
		$record->city = "Wien";
		$record->country = "Oesterreich";
		if (
			$record->save(
			)
		) {
			return TRUE;
		}
		print_r(
			$record->getErrors(
			)
		);
		return FALSE;
	}

	public function down()
	{
		CActiveRecord::$db = $this->getDbConnection(
		);
		$record = User::model(
		)->findByAttributes(
			array(
				'username' => 'admin',
			)
		);
		return $record->delete(
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
