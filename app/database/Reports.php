<?php
declare(strict_types=1);

namespace database;

use core\database\Connection;
use DateTime;
use Exception;
use model\Report;
use PDO;

/**
 * Class Reports
 * @package database
 * @author ondra
 */
class Reports
{

	private PDO $pdo;


	public function __construct(Connection $connection)
	{
		$this->pdo = $connection->getPdo();
	}


	/**
	 * Get all reports
	 * @param DateTime|null $dateTime
	 * @return Report[]
	 */
	public function getReports(?DateTime $dateTime): array
	{
		$sql = "SELECT * FROM reports";
		$reports = [];

		if (!empty($dateTime)) {
			$sql .= " WHERE datetime >= :date AND datetime < :date2";
		}

		$results = $this->pdo->prepare($sql);

		if (!empty($dateTime)) {
			$date = $dateTime->format("y-m-d");
			$results->bindParam(":date", $date);
			$dateTime2 = $dateTime->modify("+ 1 day")->format("Y-m-d");
			$results->bindParam(":date2", $dateTime2);
		}

		if ($results->execute() && $results->rowCount() > 0) {
			foreach ($results->fetchAll(PDO::FETCH_ASSOC) as $row) {
				try {
					$reports[] = new Report((int)$row["id"], floatval($row["temperature"]), floatval($row["soil_humidity"]), floatval($row["air_humidity"]), new DateTime($row["datetime"]));
				} catch (Exception $e) {
				}
			}
		}

		return $reports;
	}


	/**
	 * Return last report
	 * @return Report
	 */
	public function getLastReport(): Report
	{
		$report = new Report(0, 0, Report::SOIL_HUMIDITY_MAX, 0, new DateTime());

		$result = $this->pdo->query("SELECT * FROM last_report");

		if ($result->rowCount() > 0) {
			$row = $result->fetch(PDO::FETCH_ASSOC);
			try {
				$report = new Report((int)$row["id"], floatval($row["temperature"]), floatval($row["soil_humidity"]), floatval($row["air_humidity"]), new DateTime($row["datetime"]));
			} catch (Exception $e) {
			}
		}

		return $report;
	}

}
