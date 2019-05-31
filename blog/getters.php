<?php
/*
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/

include_once("sqlConfig.php");

$sql_connection = new mysqli($sql_host, $sql_username, $sql_password, $sql_database);

function get_nr_posts($sql) : int {
	$res = $sql->query("SELECT count(*) AS nr_posts FROM posts");
	return intval($res->fetch_assoc()["nr_posts"]);
}

function get_photos($sql, int $post_id) : array {
	$query = $sql->prepare("SELECT location, description FROM photos WHERE post_id=? ORDER BY id");
	$query->bind_param("i", $post_id);
	$query->execute();
	$res = $query->get_result();

	$photos = [];
	while($row = $res->fetch_assoc()){
		$photo = array(
			"location" => $row["location"],
			"description" => $row["description"]
			);
		$photos[] = $photo;
	}
	return $photos;
}

function get_comments($sql, int $post_id) : array {
	$query = $sql->prepare("SELECT name, date_format(date,'%D %M %Y') AS date, text FROM comments WHERE post_id=? ORDER BY date");
	$query->bind_param("i", $post_id);
	$query->execute();
	$res = $query->get_result();

	$comments = [];
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

function get_posts_range($sql, int $skip_nr, int $amount) : array {
	$query = $sql->prepare("SELECT id, title, date_format(date,'%D %M %Y') AS date FROM posts ORDER BY id DESC LIMIT ?, ?");
	$query->bind_param("ii", $skip_nr, $amount);
	$query->execute();
	$query_result = $query->get_result();

	$posts = [];

	while($row = $query_result->fetch_assoc()){
		$post_id = $row['id'];

		$posts[] = [
			"id" => $post_id,
			"title" => $row['title'],
			"date" => $row['date'],
			"photos" => get_photos($sql, $post_id),
			"comments" => get_comments($sql, $post_id)
		];
	}

	return $posts;
}

?>