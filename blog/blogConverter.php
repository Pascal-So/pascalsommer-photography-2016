<?php

include_once("sqlConfig.php");

$sql = new mysqli($sql_host, $sql_username, $sql_password, "pascalsommer_ch");

$entries = scandir("entries", 0);
foreach($entries as $e){
	if($e!="." && $e!=".."){
		$nameparts = explode("_", $entry);
    	$title = str_replace("-", " ", $nameparts[1]);
    	$dp = explode(".",$nameparts[0]); //dateparts
		$sql->query("insert into posts (title, date) values ({$title}, {$dp[0]}-{$dp[1]}-{$dp[2]} 00:00:00.000000)");
	}
}

?>