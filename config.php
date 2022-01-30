<?php
	session_start();
	date_default_timezone_set('America/Los_Angeles');
	// Define constants - constants cannot be changed after they have been declared.
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	define("DB_HOST", $url["host"]);
	define("DB_USER", $url["user"]);
	define("DB_PASS", $url["pass"]);
	define("DB_NAME", substr($url["path"],1));
?>