<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once("getters.php");
include_once("formatters.php");
include_once("commonFunctions.php");

if(!isset($_POST["skip_nr"]) || !isset($_POST["amount"])){
	invalid_request();
}

$skip_nr = intval($_POST["skip_nr"]);
$amount = intval($_POST["amount"]);

$out = format_posts_range(get_posts_range($sql_connection, $skip_nr, $amount));

if($out == ""){
	invalid_request();
}

echo $out;

?>