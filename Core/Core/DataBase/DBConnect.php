<?php

	namespace MDReal\Agro\DataBase;
	use PDO;

	class DBConnect {

		public const MySQL = 10011;
		public const PDO = 11101;
		public $query;

		public function __construct(int $connectiontype, string $server, string $username, string $password, string $dbname) {
			$this->type = $connectiontype;
			$this->connectionSuccess = false;

			switch ($this->type) {
				case self::MySQL:
				default:
					$this->connection = new \mysqli($server, $username, $password, $dbname);
					if ($this->connection->connect_error) {
						$this->connectionSuccess = false;
						$this->connectionError = $this->connection->connect_error;
						$this->connection->close();
					}
					break;
				case self::PDO:
					try {
						$this->connection = new PDO("mysql:host={$server};dbname={$dbname};charset=utf8mb4", $username, $password, [
							PDO::ATTR_EMULATE_PREPARES => false,
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
						]);
					} catch(PDOException $e) {
						$this->connectionSuccess = false;
						$this->connectionError = $e->getMessage();
						$this->connection = null;
					}
					break;
			}
			$this->connectionSuccess = true;
		}
	}