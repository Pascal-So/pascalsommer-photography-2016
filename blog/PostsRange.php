<?php

//start and end id, inclusive
//start >= end, as blog is ordered in reverse chronological order
 
include("sqlConfig.php");
include("Post.php");
include("commonFunctions.php");


if(!isset($_POST["start_id"]) || !isset($_POST["end_id"]){
	invalid_request();
}

$start = intval($_POST["start_id"]);
$end = intval($_POST["end_id"]);


if($start == 0 || $end == 0){
	invalid_request();
}

if($start < $end){
	invalid_request();
}

$sql = new mysqli($sql_host, $sql_username, $sql_password, "pascalsommer_ch");

$posts = array();

for($i = $start; $i >= $end; $i--){
	$post = new Post($i);
	if($post->load($sql)){
		$posts[] = $post;	
	}
}

if(count($posts)==0){
	invalid_request();
}

foreach($posts as $post){
	echo $post->view();
}

?>