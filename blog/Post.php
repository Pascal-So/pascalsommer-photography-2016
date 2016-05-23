<?php

//fetch individual posts

include("sqlConfig.php");
include("commonFunctions.php");

if(!isset($_POST["id"])){
	invalid_request();
}

$id = intval($_POST["id"]);

if($id <= 0){
	invalid_request();
}

$sql = new mysqli($sql_host, $sql_username, $sql_password, "pascalsommer_ch");

$res = $sql->query("select title from posts where id=" . $id);

$title = $res->fetch_assoc()["title"];

echo $title . "<br>";

?>