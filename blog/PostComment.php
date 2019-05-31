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

$prep = $sql->prepare("insert into comments (name, text, post_id) values (?, ?, ?)");
$prep->bind_param("ssi", $_POST["name"], $_POST["text"], $_POST["pid"]);

$prep->execute();

echo format_comments(get_comments($sql, $pid));


?>