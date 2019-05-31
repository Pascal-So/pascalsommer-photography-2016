<?php

//start and end id, inclusive
//start >= end, as blog is ordered in reverse chronological order

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once("Post.php");
include_once("commonFunctions.php");



if(!isset($_POST["start_id"]) || !isset($_POST["end_id"])){
	invalid_request();
}

$start = intval($_POST["start_id"]);
$end = intval($_POST["end_id"]);


$out = getRange($start, $end);

if($out == ""){
	invalid_request();
}

echo $out;

?>