<?php

//start and end id, inclusive
//start >= end, as blog is ordered in reverse chronological order
 
include("sqlConfig.php");
include("commonFunctions.php");


if(!isset($_POST["idStart"]) || !isset($_POST["idEnd"]){
	invalid_request();
}

$start = $_POST["idStart"];
$end = $_POST["idEnd"];

if($start < $end){
	invalid_request();
}

$sql = new mysqli($sql_host, $sql_username, $sql_password, "pascalsommer_ch");

$res = $sql->query("select count(*) as count form posts");

$count = $res->fetch_assoc()["count"];

if($start>$count || $end < 1){
	invalid_request();
}

$raw_posts = array();

for($i = $start; $i>=$end; $i--){
	$raw_posts[] = 
}

$posts = array();

?>