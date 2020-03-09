<?php

	$vars = [
		"insideVars" => "This is inside Variable"
	];

	return <<<HTML
	Hello M
	{{insideVars}}
HTML;