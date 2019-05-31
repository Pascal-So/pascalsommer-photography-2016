<?php

function get_photos($sql, int $id) : array {
	$res = $sql->query("SELECT location, description FROM photos WHERE post_id=" . $id . " ORDER BY id");
	$photos = array();
	while($row = $res->fetch_assoc()){
		$photo = array(
			"location" => $row["location"],
			"description" => $row["description"]
			);
		$photos[] = $photo;
	}
	return $photos;
}

function format_photos(array $photos) : string {
	$out = "";
	foreach($photos as $photo){
		$out .= "<img class='blog_img' src='{$photo['location']}' alt='{$photo['description']}'>";
	}
	return $out;
}

function get_comments($sql, int $id) : array {
	$res = $sql->query("SELECT name, date_format(date,'%D %M %Y') AS date, text FROM comments WHERE post_id=" . $id . " ORDER BY date");
	$comments = array();
	while($row = $res->fetch_assoc()){
		$comment = array(
			"name" => $row["name"],
			"date" => $row["date"],
			"text" => $row["text"],
			);
		$comments[] = $comment;
	}
	return $comments;
}

function sanitize(string $text) : string {
	return nl2br(htmlspecialchars($text));
}

function format_comments(array $comments) : string {
	$out = "";
	foreach($comments as $comment){
		$out .= "<div class='comment'>";
		$out .= "<h5 class='comment_date'>" . sanitize($comment['date']) . "</h5>";
		$out .= "<h4 class='comment_name'>" . sanitize($comment['name']) . "</h4>";
		$out .= "<p  class='comment_text'>" . sanitize($comment['text']) . "</p>";
		$out .= "</div>";
	}
	return $out;
}

?>
