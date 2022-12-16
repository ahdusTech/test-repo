<?php
class Formatter extends CFormatter {
	public function formatBoolean(
		$value
	) {
		return $value ? Yii::t(
			'app',
			$this->booleanFormat[
				1
			]
		) : Yii::t(
			'app',
			$this->booleanFormat[
				0
			]
		);
	}
}
