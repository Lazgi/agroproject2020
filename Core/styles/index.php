<?php

	header("Content-Type: text/css");
	if (file_exists(realpath(__DIR__ . "/{$this->filter->filename}.css")))
		return file_get_contents(realpath(__DIR__ . "/{$this->filter->filename}.css"));
	return 404;