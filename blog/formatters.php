<?php

include_once("config.php");

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

function format_photos(array $photos) : string {
	$out = "";
	foreach($photos as $photo){
		$out .= "<img class='blog_img' src='{$photo['location']}' alt='{$photo['description']}'>";
	}
	return $out;
}

function format_post(int $id, string $title, string $date, array $photos, array $comments) : string {
	global $config;

	$nr_comments = count($comments);
	$toggle_comments_string;
	switch($nr_comments){
		case 0:
			$toggle_comments_string = "no comments yet";
			break;
		case 1:
			$toggle_comments_string = "1 comment";
			break;
		default:
			$toggle_comments_string = "{$nr_comments} comments";
	}

	$out = "<div class='post fresh'>";
	$out.=     "<h3 class='post_title'>{$title}</h3>";
	$out.=     "<h5>{$date}</h5>";
	$out.=     format_photos($photos);
	$out.=     "<h5 class='comments_toggle'>{$toggle_comments_string}</h5>";
	$out.=     "<div class='comments_block hidden'>";
	$out.=         "<div class='post_id hidden'>{$id}</div>";
	$out.=         "<div class='comments'>";
	$out.=             format_comments($comments);
	$out.=         "</div>";

	// We don't allow the user to send comments when connected to the
	// database of a newer version of the blog.
	if($config['database_format_version'] == '2016'){
		$out.=         "<form class='comment comment_new'>";
		$out.=             "<h4 class='comment_name'>New comment</h4>";
		$out.=             "<input type='text' class='comment_input comment_input_name text_input' placeholder='Name'><br>";
		$out.=             "<textarea class='comment_input comment_input_text text_input' placeholder='Message'></textarea><br>";
		$out.=             "<input type='button' value='SEND' class='comment_send comment_input'><br>";
		$out.=         "</form>";
	}

	$out.=     "</div>";
	$out.= "</div>";

	return $out;
}

function format_posts_range(array $posts) : string {
	$out = "";
	foreach($posts as $post){
		$out .= format_post($post['id'], $post['title'], $post['date'], $post['photos'], $post['comments']);
	}
	return $out;
}

?>
