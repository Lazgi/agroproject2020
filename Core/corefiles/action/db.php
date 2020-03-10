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
	$y->data = "xcxcax";
	$y->priller = "PR";
	// $y->store(); // Creates Table and Adds new Items
	// $y->update("id", 2); // Update this item. WIP
	// $y->delete("id", 2); // Deletes Selected Item. WIP
	// $y->truncate(); // Empty Table
	// $y->drop(); // DROP Table

	return;