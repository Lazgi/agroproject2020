<?php

	namespace MDReal\Agro\Controllers;

	class FileController {

		public function __construct(Filter $filter) {
			$this->filter = $filter;
			$this->selFile = __DIR__;
			$this->p404 = realpath(dirname(dirname($this->selFile)) . "/corefiles/404.php");
			switch ($this->filter->filetype) {
				case "phpexec":
				case "html":
					$this->content = realpath(dirname(dirname($this->selFile)) . "{$this->filter->filepath}{$this->filter->filename}.php");
					break;
				case "css":
				case "js":
					$this->content = realpath(dirname(dirname($this->selFile)) . "{$this->filter->filepath}index.php");
					break;
			}
			$this->toGET();
		}

		public function getFile() {
			if (empty($this->content))
				$this->content = $this->p404;
			$fileContent = require($this->content);
			if (!empty($vars))
				foreach ($vars as $q => $w)
					$fileContent = str_replace("{{" . $q . "}}", print_r($w, 1), $fileContent);
			return $fileContent;
		}

		public function toGET() {
			if (!empty($this->filter->getParams))
				foreach ($this->filter->getParams as $q => $w)
					$_GET[$q] = $w;
		}

	}
