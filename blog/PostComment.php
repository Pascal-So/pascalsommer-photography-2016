<?php
/*
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/

include_once("sqlConfig.php");
include_once("commonFunctions.php");
include_once("PostFunctions.php");

if(!isset($_POST["name"]) || !isset($_POST["text"]) || !isset($_POST["pid"])){
	echo "asdf";
	abort();
}

$sql = new mysqli($sql_host, $sql_username, $sql_password, $sql_database);

$prep = $sql->prepare("insert into comments (name, text, post_id) values (?, ?, ?)");

$name = $_POST["name"];
$text = stripNewlines($_POST["text"]);
$pid  = $_POST["pid"];

$prep->bind_param("ssi", $name, $text, $pid);

$prep->execute();

echo format_comments(get_comments($sql, $pid));


?>