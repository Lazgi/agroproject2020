<?php

// https://websitebeaver.com/php-pdo-prepared-statements-to-prevent-sql-injection

	header("Content-Type: application/json");
	require realpath(__DIR__ . '/../../core.php');
	use MDReal\Agro\DataBase\DBConnect;
	use MDReal\Agro\DataBase\DataBase;

	$x = new DataBase(new DBConnect(DBConnect::MySQL, "localhost", "root", "", "agrodb"), [
		"Table" => ["uname", "data", "priller"],
		"Tablee" => ["changedid", "uname"]
	], "Test");
	$y = $x->Table(1);
	$y->uname = "xxxx";
	$y->changedid = "xx";
	$y->store();
	print_r($y);

	return;