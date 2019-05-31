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
    invalid_request();
}

$sql = new mysqli($sql_host, $sql_username, $sql_password, $sql_database);

$name = $_POST["name"];
$text = $_POST["text"];
$pid = $_POST["pid"];

$prep = $sql->prepare("INSERT INTO comments (name, text, post_id) VALUES (?, ?, ?)");
$prep->bind_param("ssi", $name, $text, $pid);

$prep->execute();

echo format_comments(get_comments($sql, $pid));


?>