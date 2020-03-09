<?php

	namespace MDReal\Agro\Controllers;

	class FileController {

		public function __construct(Filter $filter) {
			$this->filter = $filter;
			$this->selFile = __DIR__;
			switch ($this->filter->filetype) {
				case "html":
					$this->content = realpath(dirname(dirname($this->selFile)) . "/corefiles/{$this->filter->filename}.php");
					$this->p404 = realpath(dirname(dirname($this->selFile)) . "/corefiles/404.php");
					break;
				case "css":
					break;
				case "js":
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
