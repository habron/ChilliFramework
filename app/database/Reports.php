<?php
declare(strict_types=1);

namespace database;

use core\database\Connection;
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
	 * @return array
	 */
	public function getReports(): array
	{

	}

}
