<?php

	namespace MDReal\Agro\Controllers;

	class PageController {

		public function __construct($meta, $style, $script, $title, $body, Filter $filter) {

			$this->meta = $meta;
			$this->style = $style;
			$this->script = $script;
			$this->title = $title;
			$this->body = $body;
			$this->filter = $filter;

		}

		public function build() {

			if ($this->filter->filetype !== "html")
				return $this->body();
			return $this->head() . $this->body() . $this->close();

		}

		public function head(){
			$filter = new Filter("/head");
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
			$filter = new Filter("/close");
			$filter->parse();
			$file = (new FileController($filter))->getFile();
			$file = str_replace("{{js}}", $this->parseJS(), $file);
			return $file;
		}

		private function parseMeta() {
			$stringMeta = "";
			foreach ($this->meta as $q => $w)
				$stringMeta .= "\n<meta name=\"{$q}\" content=\"{$w}\" />";
			return substr($stringMeta, 1);
		}

		private function parseCSS() {
			$stringCSS = "";
			foreach ($this->style as $q => $w)
				$stringCSS .= "\n<link rel=\"stylesheet\" href=\"/css/{$w}.css\" />";
			return substr($stringCSS, 1);
		}

		private function parseJS() {
			$stringJS = "";
			foreach ($this->style as $q => $w)
				$stringJS .= "\n<script src=\"/js/{$w}.js\"></script>";
			return substr($stringJS, 1);
		}
	}