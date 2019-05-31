<?php

// Initially, posts were marked by directories in the `entries` dir,
// named in the format "YYYY.MM.DD_Post-Title". All the photos in
// the post directory are then part of the post.

// This script scans all the posts and makes database entries instead,
// which seems like a more robust solution. The photos are not moved
// to a different directory, just the listing works different now.

die("Blog converter has been disabled in order to avoid problems from repeated execution.");

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once("sqlConfig.php");

$base_path = "";

$sql = new mysqli($sql_host, $sql_username, $sql_password, "pascalsommer_ch_blog");



$sql->query("delete from photos");
$sql->query("delete from posts");
$sql->query("alter table photos auto_increment = 1");
$sql->query("alter table posts auto_increment = 1");


$id = 1;

$entries = scandir($base_path."entries", 0);
foreach($entries as $e){
	if($e!="." && $e!=".."){
		$nameparts = explode("_", $e);
    	$title = str_replace("-", " ", $nameparts[1]);
    	$dp = explode(".",$nameparts[0]); //dateparts
    	echo $title . "<br/>";
    	$query = "insert into posts (title, date) values (\"{$title}\", \"{$dp[0]}-{$dp[1]}-{$dp[2]} 00:00:00.000000\")";
    	//echo "executing: "  . $query . "<br>";
		$sql->query($query);
		if ($sql->connect_errno) {
		    echo "Failed to execute MySQL query: (" . $sql->connect_errno . ") " . $sql->connect_error . "<br>";
		}

		// ########### photos

		$photos = scandir($base_path."entries/".$e, 0);
		foreach($photos as $p){
			if($p !="." && $p!=".."){
				$path = $base_path."entries/".$e."/".$p;

				$query = "insert into photos (post_id, location) values ({$id}, \"{$path}\")";
				//echo $query . "<br>";
				$sql->query($query);
				if ($sql->connect_errno) {
				    echo "Failed to execute MySQL query: (" . $sql->connect_errno . ") " . $sql->connect_error . "<br>";
				}
			}
		}



		$id++;
	}
}

?>