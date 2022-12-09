<?php
class Fill_typeinsCommand extends CConsoleCommand {
	public function run(
		$args
	) {
		$connection = Yii::app(
		)->db;
		$collect_command = $connection->createCommand(
			"SELECT domain
    FROM tbl_typein_domain
    GROUP BY domain"
		);
		$dataReader = $collect_command->query(
		);
		$domain_entries = array(
		);
		while (
			FALSE !== (
				$row = $dataReader->read(
				)
			)
		) {
			array_push(
				$domain_entries,
				$row
			);
		}
		$today = time(
		);
		$check_command = $connection->createCommand(
			"SELECT *
    FROM tbl_typein_stats
    WHERE domain=:domain
    AND access_date=:date"
		);
		$insert_command = $connection->createCommand(
			"INSERT
    INTO tbl_typein_stats (domain,access_date,accesses,counted_on)
    SELECT :domain,:date,0,:now"
		);
		foreach (
			$domain_entries as $entry
		) {
			for (
				$backlog = 0;
				11 > $backlog;
				$backlog++
			) {
				$date = strftime(
					"%Y-%m-%d",
					$today - (
						$backlog * 86400
					)
				);
				$check_command->bindParam(
					":domain",
					$entry[
						"domain"
					]
				);
				$check_command->bindParam(
					":date",
					$date
				);
				$dataReader = $check_command->query(
				);
				if (
					FALSE === (
						$row = $dataReader->read(
						)
					)
				) {
					echo "inserting\n";
				} else {
					continue;
				}
				$insert_command->bindParam(
					":domain",
					$entry[
						"domain"
					]
				);
				$insert_command->bindParam(
					":date",
					$date
				);
				$now = strftime(
					"%Y-%m-%d %H:%M:%S",
					time(
					)
				);
				$insert_command->bindParam(
					":now",
					$now
				);
				$insert_command->execute(
				);
			}
		}
	}
}
?>
