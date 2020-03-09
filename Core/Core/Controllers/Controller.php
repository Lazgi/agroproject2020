<?php

	namespace MDReal\Agro\Controllers;

	class Controller {

		public function __construct($header, $server, $get, $cookie) {
			$this->header = $header;
			$this->server = $server;
			$this->get = $get;
			$this->cookie = $cookie;
		}

		public function getController() {

			$requesturi = $this->server['REQUEST_URI'];
			$request = new Filter($requesturi);
			$request->parse();
			$page = new FileController($request);
			return new PageController([
				"charset" => "UTF-8"
			], [$request->filename], [$request->filename], "Ready Page", $page->getFile(), $request);
			/*
Lampocka
			*/


		}

	}
