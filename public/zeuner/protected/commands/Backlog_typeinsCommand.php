<?php
class Backlog_typeinsCommand extends CConsoleCommand {
	public function run(
		$args
	) {
		$connection = Yii::app(
		)->db;
		$backlog_start = Yii::app(
		)->Date->applyOffset(
			Yii::app(
			)->Date->now(
			),
			-10
		);
		$backlog_start_mysql = Yii::app(
		)->Date->toMysql(
			$backlog_start
		);
		$backlog_command = $connection->createCommand(
			"SELECT domain,accesses
    FROM tbl_typein_stats
    WHERE access_date>:backlog_start
    GROUP BY domain,access_date"
		);
		$backlog_command->bindParam(
			":backlog_start",
			$backlog_start_mysql
		);
		$dataReader = $backlog_command->query(
		);
		$backlog_entries = array(
		);
		$current_domain = -1;
		while (
			FALSE !== (
				$row = $dataReader->read(
				)
			)
		) {
			if (
				$row[
					"domain"
				] != $current_domain
			) {
				if (
					-1 != $current_domain
				) {
					$entry = array(
						"domain" => $current_domain,
						"backlog" => $backlog_data,
					);
					array_push(
						$backlog_entries,
						$entry
					);
				}
				$current_domain = $row[
					"domain"
				];
				$backlog_data = array(
				);
			} else {
				array_unshift(
					$backlog_data,
					$row[
						"accesses"
					]
				);
			}
		}
		if (
			-1 != $current_domain
		) {
			$entry = array(
				"domain" => $current_domain,
				"backlog" => $backlog_data,
			);
			array_push(
				$backlog_entries,
				$entry
			);
		}
		$column_names = array(
		);
		$column_values = array(
		);
		$assignments = array(
		);
		for (
			$backlog = 0;
			10 > $backlog;
			$backlog++
		) {
			array_push(
				$column_names,
				"backlog$backlog"
			);
			array_push(
				$column_values,
				":backlog$backlog"
			);
			array_push(
				$assignments,
				"backlog$backlog=:backlog$backlog"
			);
		}
		$check_command = $connection->createCommand(
			"SELECT *
    FROM tbl_typein_backlog
    WHERE domain=:domain"
		);
		$insert_command = $connection->createCommand(
			"INSERT
    INTO tbl_typein_backlog (domain," . implode(
				",",
				$column_names
			) . ",aggregated_on)
    SELECT :domain," . implode(
				",",
				$column_values
			) . ",:now"
		);
		$update_command = $connection->createCommand(
			"UPDATE tbl_typein_backlog
    SET " . implode(
				",",
				$assignments
			) . ",aggregated_on=:now
    WHERE domain=:domain"
		);
		foreach (
			$backlog_entries as $entry
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
			$index = 0;
			foreach (
				$entry[
					"backlog"
				] as $key => $value
			) {
				$command->bindParam(
					":backlog$index",
					$entry[
						"backlog"
					][
						$key
					]
				);
				$index++;
			}
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
