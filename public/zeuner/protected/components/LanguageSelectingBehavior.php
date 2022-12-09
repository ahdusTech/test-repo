<?php
	class LanguageSelectingBehavior extends CBehavior {
		public $supported_languages;

		public function attach(
			$owner
		) {
			$owner->attachEventHandler(
				'onBeginRequest',
				array(
					$this,
					'beginRequest'
				)
			);
		}

		public function beginRequest(
			CEvent $event
		) {
			$language = Yii::app(
			)->request->getPreferredLanguage(
				$this->supported_languages
			);
			Yii::app(
			)->language = $language;
		}
	}
?>
