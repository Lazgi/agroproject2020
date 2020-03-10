<?php

	namespace MDReal\Agro\Controllers;

	class PageController {

		public function __construct(array $meta, array $style, array $script, string $title, FileController $body) {

			$this->meta = $meta;
			$this->style = $style;
			$this->script = $script;
			$this->title = $title;
			$this->body = $body->getFile();
			$this->filter = $body->filter;

		}

		public function build() {

			if ($this->filter->filetype !== "html") {
				$page = $this->body();
				if ($page === 404) {
					$file = (new FileController((new Filter("/404", true))->parse()))->getFile();
					return $this->head() . $file . $this->close();
				}
				return $page;
			}
			return $this->head() . $this->body() . $this->close();

		}

		public function head(){
			$filter = new Filter("/head", true);
			$filter->parse();
			$file = (new FileController($filter))->getFile();
			$file = str_replace("{{meta}}", $this->parseMeta(), $file);
			$file = str_replace("{{title}}", $this->title, $file);
			$file = str_replace("{{css}}", $this->parseCSS(), $file);
			return $file;
		}

		public function body(){
			return $this->body;
		}
		
		public function close(){
			$filter = new Filter("/close", true);
			$filter->parse();
			$file = (new FileController($filter))->getFile();
			$file = str_replace("{{js}}", $this->parseJS(), $file);
			return $file;
		}

		private function parseMeta() {
			$stringMeta = "";
			foreach ($this->meta as $q => $w)
				$stringMeta .= "\n\t<meta name=\"{$q}\" content=\"{$w}\" />";
			return substr($stringMeta, 2);
		}

		private function parseCSS() {
			$stringCSS = "";
			foreach ($this->style as $q => $w)
				$stringCSS .= "\n\t<link rel=\"stylesheet\" href=\"/css/{$w}.css\" />";
			return substr($stringCSS, 2);
		}

		private function parseJS() {
			$stringJS = "";
			foreach ($this->script as $q => $w)
				$stringJS .= "\n\t<script src=\"/js/{$w}.js\"></script>";
			return substr($stringJS, 2);
		}
	}