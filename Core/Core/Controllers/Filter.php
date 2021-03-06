<?php

	namespace MDReal\Agro\Controllers;

	class Filter {

		public function __construct($requ, $secreted = false) {
			$this->requ = $requ;
			$this->sc = $secreted;
		}

		public function parse() {
			if (preg_match("/\/(close|head|404)(?:\?(.*))?/", $this->requ, $m) && !$this->sc)
				return;

			if (preg_match("/\/act\/(\w+)(?:\?(.*))?/", $this->requ, $m)) {
				$this->filename = $m['1'];
				$this->filetype = "phpexec";
				$this->filepath = "/corefiles/action/";
				if (!empty($m['2']))
					$this->getParams = $this->parseParams($m['2']);
			} elseif (preg_match("/\/(css|js)\/(\w+)\.(css|js)(?:\?(.*))?/", $this->requ, $m)) {
				if ($m['1'] !== $m['3'])
					return;
				$this->filename = $m['2'];
				$this->filetype = $m['1'];
				$this->filepath = "/corefiles/media/{$this->filetype}/";
				if (!empty($m['2']))
					$this->getParams = $this->parseParams($m['2']);
			} elseif (preg_match("/\/(\w+)(?:\?(.*))?/", $this->requ, $m)) {
				$this->filename = $m['1'];
				$this->filetype = "html";
				$this->filepath = "/corefiles/";
				if (!empty($m['2']))
					$this->getParams = $this->parseParams($m['2']);
			}

			return $this;
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
				"filepath" => $this->filepath,
				"get" => $this->getParams??""
			];
		}
	}