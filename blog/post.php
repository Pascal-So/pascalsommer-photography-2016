<?php

//start and end id, inclusive
//start <= end
 

function abort(){
	http_response_code(400);
	exit();
}

if(!isset($_POST["idStart"]) || !isset($_POST["idEnd"]){
	abort();
}

$start = $_POST["idStart"];
$end = $_POST["idEnd"];

if($start > $end){
	abort();
}

?>