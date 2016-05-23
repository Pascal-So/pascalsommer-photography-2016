<?php
	
function get_photos($sql, $id){
	$res = $sql->query("select location, description from photos where post_id=" . $id . " order by id");
	$photos = array();
	while($row = $res->fetch_assoc()){
		$photo = array(
			"location" => $res["location"],
			"description" => $res["description"]
			);
		$photos[] = $photo;
	}
	return $photos;
}

function format_photos($photos){
	$out = "";
	foreach($photos as $photo){
		out .= "<img class='blog_img' src='{$photo['location']}' alt='{$photo['description']}'>";
	}
	return $out;
}

function get_comments($sql, $id){
	$res = $sql->query("select name, date_format(date,'%D %M %Y') as date, text from comments where post_id=" . $id . " order by date");
	$comments = array();
	while($row = $res->fetch_assoc()){
		$comment = array(
			"name" => $res["name"],
			"date" => $res["date"],
			"text" => $res["text"],
			);
		$comments[] = $comment;
	}
	return $comments;
}

function format_comments($comments){
	$out = "";
	foreach($comments as $comment){
		out .= "<div class='comment'>";
		out .= "<h5 class='comment_date'>{$comment['date']}</h5>";
		out .= "<h4 class='comment_name'>{$comment['name']}</h4>";
		out .= "<p  class='comment_text'>{$comment['text']}</p>";
		out .= "</div>";
	}
	return $out;
}

?>
