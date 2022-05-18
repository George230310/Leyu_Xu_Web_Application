<?php
	session_start();
	date_default_timezone_set('America/Los_Angeles');
	// Define constants - constants cannot be changed after they have been declared.
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$db_host = $url["host"];
	$db_user = $url["user"];
	$db_pass = $url["pass"];
	$db_name = substr($url["path"],1);
	define("DB_HOST", $url["host"]);
	define("DB_USER", $url["user"]);
	define("DB_PASS", $url["pass"]);
	define("DB_NAME", substr($url["path"],1));
?>