<?php
class AutobuyCommand extends CConsoleCommand {
	public function run(
		$args
	) {
		$_SERVER[
			'SERVER_NAME'
		] = 'undefined';
		$model = new TblDomain(
			'search'
		);
		$model->unsetAttributes(
		);
		$criteria = array(
		);
		$criteria[
			'auction'
		] = 1;
		$model->attributes = $criteria;
		$dataProvider = $model->search(
		);
		$iterator = new CDataProviderIterator(
			$dataProvider
		);
		foreach (
			$iterator as $domain
		) {
			if (
				$domain->get_auction_elapsed_days(
				) >= $domain->get_auction_duration(
				)
			) {
				echo $domain->name . " expired\n";
				system(
					escapeshellarg(
						'curl'
					) . ' ' . escapeshellarg(
						Yii::app(
						)->urlManager->createUrl(
							'tblDomain/status',
							array(
								'id' => $domain->id,
							)
						)
					)
				);
			}
		}
	}
}
?>
