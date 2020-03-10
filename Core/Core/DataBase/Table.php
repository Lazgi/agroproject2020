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
				$this->query = "CREATE TABLE IF NOT EXISTS `{$this->table}` (`id` INT(11) PRIMARY KEY AUTO_INCREMENT) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;";
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

		public function init() {
			return self::$database->queryExec($this->query);
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

		public function update() {}

		public function delete() {}

		public function truncate() {}

		public function drop($tbname) {}

		public function dropall() {}

	}