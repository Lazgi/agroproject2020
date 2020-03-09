<?php
	
	// header("Content-Type: application/json");
	require "Core/core.php";

	use MDReal\Agro\Controllers\Controller as c;

	$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] === "/" ? "/home" : $_SERVER['REQUEST_URI'];
	$c = new c(getallheaders(), $_SERVER, $_GET, $_COOKIE);
	$x = $c->getController();
	echo $x->build();