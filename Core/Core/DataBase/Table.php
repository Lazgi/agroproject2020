<?php
	
	namespace MDReal\Agro\DataBase;

	class Table extends DataBase {

		/**
		 * About database and hide database
		 * data from simple print_r() function
		 */
		private static $database;

		public function __construct($tablename, DataBase $database) {

			$this->table = $tablename;
			self::$database = $database;
			$this->query = "";
			if (!in_array($this->table, $this->normalizeArray(self::$database->fetch("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '{$this->table}'"))))
				$this->query = "CREATE TABLE `{$this->table}` (`id` INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;";
		}

		public function getAllKeys() {
			if (!isset($this->columns))
				return $this->columns = $this->normalizeArray(self::$database->fetch("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$this->table}'"));
			return $this->columns;
		}

		private function normalizeArray(array $arr) {
			$x = [];
			if (count($arr) > 1) {
				foreach ($arr as $q => $w)
					if (count($w) === 1)
						$x[] = $w[key($w)];
				return $x;
			} elseif (count($arr) === 1)
				return $arr['0'];
			else
				return [];
		}

		public function addKey($key) {
			if (!in_array($key, $this->getAllKeys()))
				$this->query .= " ALTER TABLE `{$this->table}` ADD `{$key}` VARCHAR(255) NOT NULL;";
		}

		public function init($fetch = false) {
			foreach (explode(";", $this->query) as $q => $w) {
				if (!empty($w)) {
					if ($fetch)
						$x[] = self::$database->fetch(trim($w));
					else
						$x[] = self::$database->queryExec(trim($w));
				}
			}
			return $x;
		}

		private function getUserInpData() {
			$userInpData = [];
			foreach ($this as $q => $w)
				if ($q !== "table" && $q !== "query" && $q !== "columns")
					$userInpData[$q] = $w;
			return $userInpData;
		}

		public function store() {
			$insert = " INSERT INTO `{$this->table}` (";
			$columns = "";
			$value = ") VALUES (";
			$values = "";
			$end = ");";
			foreach ($this->getUserInpData() as $q => $w) {
				$columns .= ", `{$q}`";
				$values  .= ", '{$w}'";
			}
			$this->query .= $insert . substr($columns, 2) . $value . substr($values, 2) . $end;
			$this->init();
		}

		private function load($key, $value) {
			$this->query = "SELECT * FROM `{$this->table}` WHERE `{$key}` = '{$value}'";
			return $this->init(true)['0']['0'];
		}

		public function update($key, $value) {
			$rows = self::$database->tables[self::$database->Tables[$this->table]];
			$data = array_splice($this->load($key, $value), 1);
			$user = $this->getUserInpData();
			$update = "UPDATE `{$this->table}` SET ";
			foreach ($rows as $q => $w)
				$update .= "`{$w}` = '{$user[$w]}', ";
			$this->query = substr($update, 0, -2) . " WHERE `{$key}` = '{$value}';";
			$this->init();
		}

		public function delete($key, $value) {
			/*DELETE FROM table_name WHERE condition*/
			$delete = "DELETE FROM `{$this->table}` WHERE `{$key}` = '{$value}';";
			$this->query = $delete;
			$this->init();
		}

		public function truncate() {
			$this->query = "TRUNCATE TABLE `{$this->table}`;";
			$this->init();
		}

		public function drop() {
			$this->query = "DROP TABLE `{$this->table}`;";
			$this->init();
		}
	}