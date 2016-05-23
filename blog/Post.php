<?php

include("PostFunctions.php");

class Post {

	$title = "";
	$date = "";

	$photos = array();
	
	$comments = array();
	
	public function load($sql, $id){
		$res = $sql->query("select title, date_format(date,'%D %M %Y') as date from posts where id=" . $id);
		$row = $res->fetch_assoc();
		$title = $row["title"];
		$date = $row["date"];

		$photos = get_photos($sql, $id);

		$comments = get_comments($sql, $id);
	}

	public function view(){
		$out = "<div class='post'>";
		$out.= "<h3 class='post_title'>{$title}</h3>";
		$out.= "<h5>{$date}</h5>"
		$out.= format_photos($photos);
	}
}

?>