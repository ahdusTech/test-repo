<?php
class Read_typeinsCommand extends CConsoleCommand {
	public function run(
		$args
	) {
		global $staging_subdomain;
		$known_tuples = array(
		);
		while (
			$line = fgets(
				STDIN
			)
		) {
			$matched = array(
			);
			preg_match(
				'/^([^ ]+) - - \[([0-9a-zA-Z\/:+ ]*)\] "GET \/tblDomain\/status\/([0-9]*) HTTP\/1\.[0-9]" [0-9]+ [0-9]+ "http:\/\/([0-9a-zA-Z.-]*)' . $staging_subdomain . '\/" "[^"]*"$/',
				$line,
				$matched
			);
			if (
				0 == count(
					$matched
				)
			) {
				continue;
			}
			$date = strftime(
				"%Y-%m-%d",
				strtotime(
					$matched[
						2
					]
				)
			);
			$domain = TblDomain::model(
			)->find(
				'LOWER(name)=?',
				array(
					$matched[
						4
					]
				)
			);
			if (
				$domain->id != $matched[
					3
				]
			) {
				echo "wrong referer\n";
				continue;
			}
			if (
				!isset(
					$known_tuples[
						$matched[
							3
						]
					]
				)
			) {
				$known_tuples[
					$matched[
						3
					]
				] = array(
				);
			}
			if (
				!isset(
					$known_tuples[
						$matched[
							3
						]
					][
						$date
					]
				)
			) {
				$known_tuples[
					$matched[
						3
					]
				][
					$date
				] = array(
				);
			}
			if (
				isset(
					$known_tuples[
						$matched[
							3
						]
					][
						$date
					][
						$matched[
							1
						]
					]
				)
			) {
				continue;
			}
			$known_tuples[
				$matched[
					3
				]
			][
				$date
			][
				$matched[
					1
				]
			] = TRUE;
			$connection = Yii::app(
			)->db;
			$command = $connection->createCommand(
				"SELECT *
    FROM tbl_typein_domain
    WHERE domain=:domain
    AND access_date=:date
    AND accessing_ip=:ip"
			);
			$command->bindParam(
				":domain",
				$matched[
					3
				]
			);
			$command->bindParam(
				":date",
				$date
			);
			$command->bindParam(
				":ip",
				$matched[
					1
				]
			);
			$dataReader = $command->query(
			);
			if (
				FALSE !== (
					$row = $dataReader->read(
					)
				)
			) {
				echo "already logged\n";
				continue;
			}
			$command = $connection->createCommand(
				"INSERT
    INTO tbl_typein_domain (domain,access_date,accessing_ip,logged_on)
    SELECT :domain,:date,:ip,:now"
			);
			$command->bindParam(
				":domain",
				$matched[
					3
				]
			);
			$command->bindParam(
				":date",
				$date
			);
			$command->bindParam(
				":ip",
				$matched[
					1
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
