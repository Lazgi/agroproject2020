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
			], ["xx"], ["xd"], "Ready Page", $page->getFile());
			/*
Lampocka
			*/


		}

	}
