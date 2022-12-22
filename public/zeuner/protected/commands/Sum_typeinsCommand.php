<?php
class Sum_typeinsCommand extends CConsoleCommand {
	public function run(
		$args
	) {
		$connection = Yii::app(
		)->db;
		$one_year_ago = Yii::app(
		)->Date->applyOffset(
			Yii::app(
			)->Date->now(
			),
			-366
		);
		$one_year_ago_mysql = Yii::app(
		)->Date->toMysql(
			$one_year_ago
		);
		$sum_command = $connection->createCommand(
			"SELECT domain,min(access_date) AS oldest,max(access_date) AS newest,sum(accesses) AS accesses
    FROM tbl_typein_stats
    WHERE access_date>:one_year_ago
    GROUP BY domain"
		);
		$sum_command->bindParam(
			":one_year_ago",
			$one_year_ago_mysql
		);
		$dataReader = $sum_command->query(
		);
		$stat_entries = array(
		);
		while (
			FALSE !== (
				$row = $dataReader->read(
				)
			)
		) {
			array_push(
				$stat_entries,
				$row
			);
		}
		$check_command = $connection->createCommand(
			"SELECT *
    FROM tbl_typein_sums
    WHERE domain=:domain"
		);
		$insert_command = $connection->createCommand(
			"INSERT
    INTO tbl_typein_sums (domain,days,accesses,counted_on)
    SELECT :domain,:days,:accesses,:now"
		);
		$update_command = $connection->createCommand(
			"UPDATE tbl_typein_sums
    SET accesses=:accesses,days=:days,counted_on=:now
    WHERE domain=:domain"
		);
		foreach (
			$stat_entries as $entry
		) {
			$check_command->bindParam(
				":domain",
				$entry[
					"domain"
				]
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
				$command = $insert_command;
			} else {
				echo "updating\n";
				$command = $update_command;
			}
			$command->bindParam(
				":domain",
				$entry[
					"domain"
				]
			);
			$days = Yii::app(
			)->Date->daysCount(
				$entry[
					"newest"
				],
				$entry[
					"oldest"
				]
			) + 1;
			$command->bindParam(
				":days",
				$days
			);
			$command->bindParam(
				":accesses",
				$entry[
					"accesses"
				]
			);
			$now = strftime(
				"%Y-%m-%d %H:%M:%S",
				time(
				)
			);
			$command->bindParam(
				":now",
				$now
			);
			$command->execute(
			);
		}
	}
}
?>
