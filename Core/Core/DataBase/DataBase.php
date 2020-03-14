<?php

	namespace MDReal\Agro\DataBase;

	class DataBase {

		/**
		 * About Connection and hide connection
		 * data from simple print_r() function
		 */
		private static $connection;

		public function __construct(DBConnect $connection, array $tables, string $tableprefix = "") {
			self::$connection = $connection;
			$this->tables = $tables;
			$this->prefix = $tableprefix;
			$this->tables();
		}

		protected function queryExec($query, $data = []) {
			if (self::$connection->type === DBConnect::MySQL) {
				return self::$connection->connection->query($query);
			}
			elseif (self::$connection->type === DBConnect::PDO)
				return self::$connection->connection->prepare($query)->execute($data);
			/*    try {
        $db = new PDO("mysql:host=192.168.0.1;charset=utf8", "username", "password");
        $username = $_POST["txtUsername"];
        $cmd = $db->prepare("
            SELECT Password FROM `tblusers` WHERE Username = :username;
        ");
        $cmd->bindParam(':username', $username, PDO::PARAM_STR);
        $cmd->execute();
        $result = $cmd->fetch();
        return $result[0];
    } catch (Exception $e) { echo $e->getMessage(); return; }*/
		}

		protected function fetch($query, $data = []) {
			if (self::$connection->type === DBConnect::MySQL) {
				$rawQuery = $this->queryExec($query, $data);
				$res = $rawQuery->fetch_all();
			}
			return $res;
		}

		public function Table($tbname) {
			if (preg_match("/\d+/", $tbname) && $tbname < count($this->tableList)) {
				$table = new Table($this->tableList[$tbname], $this);
				foreach ($this->tables[$this->Tables[$this->tableList[$tbname]]] as $e => $r)
					$table->addKey($r);
				return $table;
			}
			return new Table($tbname, $this);
		}

		private function tables() {
			foreach ($this->tables as $q => $w) {
				$tbname = $this->snake_case($this->prefix . $q);
				$this->Tables[$tbname] = $q;
				$this->tableList[] = $tbname;
			}
		}

		private function snake_case(string $string) {

			preg_match_all("/[A-Z]/", $string, $m);
			foreach ($m['0'] as $q => $w)
				$string = str_replace($w, "_" . strtolower($w), $string);
			return substr($string, 0, 1) === "_" ? substr($string, 1) : $string;

		}

	}