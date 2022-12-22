<?php
class Count_typeinsCommand extends CConsoleCommand {
	public function run(
		$args
	) {
		$connection = Yii::app(
		)->db;
		$count_command = $connection->createCommand(
			"SELECT domain,access_date,count(accessing_ip) AS accesses
    FROM tbl_typein_domain
    GROUP BY domain,access_date"
		);
		$dataReader = $count_command->query(
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
    FROM tbl_typein_stats
    WHERE domain=:domain
    AND access_date=:date"
		);
		$insert_command = $connection->createCommand(
			"INSERT
    INTO tbl_typein_stats (domain,access_date,accesses,counted_on)
    SELECT :domain,:date,:accesses,:now"
		);
		$update_command = $connection->createCommand(
			"UPDATE tbl_typein_stats
    SET accesses=:accesses,counted_on=:now
    WHERE domain=:domain
    AND access_date=:date"
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
			$check_command->bindParam(
				":date",
				$entry[
					"access_date"
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
			$command->bindParam(
				":date",
				$entry[
					"access_date"
				]
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
