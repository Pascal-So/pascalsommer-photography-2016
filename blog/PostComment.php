<?php
/*
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/

include_once("getters.php");
include_once("formatters.php");
include_once("commonFunctions.php");

if(!isset($_POST["name"]) || !isset($_POST["text"]) || !isset($_POST["pid"])){
    invalid_request();
}

$name = $_POST["name"];
$text = $_POST["text"];
$post_id = $_POST["pid"];

$query = $sql_connection->prepare("INSERT INTO comments (name, text, post_id) VALUES (?, ?, ?)");
$query->bind_param("ssi", $name, $text, $post_id);
$query->execute();

echo format_comments(get_comments($sql_connection, $post_id));


?>