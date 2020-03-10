<?php

	if ($_SERVER['REQUEST_METHOD'] === "POST") {
		echo 'POST REQUEST_METHOD';
		print_r($_POST);
	} else {
		echo "GET REQUEST_METHOD";
		print_r($_GET);
	}

	return;