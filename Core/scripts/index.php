<?php
	
	header("Content-Type: application/javascript");
	if (file_exists(realpath(__DIR__ . "/{$this->filter->filename}.js")))
		return file_get_contents(realpath(__DIR__ . "/{$this->filter->filename}.js"));
	return 404;