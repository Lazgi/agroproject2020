<?php

	namespace MDReal\Agro\Controllers;

	class Filter {

		public function __construct($requ) {
			$this->requ = $requ;
		}

		public function parse() {

			if (preg_match_all("/\/(\w+)(?:\?(.*))?/", $this->requ, $m)) {
				$this->filename = $m['1']['0'];
				$this->filetype = "html";
				if (!empty($m['2']))
					$this->getParams = $this->parseParams($m['2']['0']);
			}

		}

		public function parseParams($params) {
			$x = [];
			foreach (explode("&", $params) as $q => $w) {
				$u = explode("=", $w);
				$x[$u['0']] = $u['1'];
			}
			return $x;
		}

		public function __debugInfo() {
			return [
				"filename" => $this->filename,
				"filetype" => $this->filetype,
				"get" => $this->getParams??""
			];
		}

	}
