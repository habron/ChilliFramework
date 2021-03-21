<?php
declare(strict_types=1);


namespace core\database;

use PDO;
use PDOException;

/**
 * Class Connection
 * @package core\database
 * @author ondra
 */
class Connection
{

	private PDO $pdo;


	public function __construct()
	{
		try {
			$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .
				';charset=UTF8',DB_USERNAME,DB_PASSWORD);
			$pdo->exec("SET NAMES 'utf8'");
			$this->pdo = $pdo;
		} catch (PDOException $exc) {
			http_response_code(503);
		}
	}

	/**
	 * @return PDO
	 */
	public function getPdo(): PDO
	{
		return $this->pdo;
	}

}