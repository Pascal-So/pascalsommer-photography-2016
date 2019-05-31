<?php
/*
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/

include_once("config.php");

$sql_connection = new mysqli($config['sql_host'], $config['sql_username'], $config['sql_password'], $config['sql_database']);

function get_nr_posts($sql) : int {
	$res = $sql->query("SELECT count(*) AS nr_posts FROM posts");
	return intval($res->fetch_assoc()["nr_posts"]);
}

function get_photos($sql, int $post_id) : array {
	global $config;

	$blog_2016_query = "SELECT location, description FROM photos WHERE post_id=? ORDER BY id";
	$blog_2018_query = "SELECT path as location, description FROM photos WHERE post_id=? ORDER BY weight ASC";

	$query = $sql->prepare($config['database_format_version'] == '2018' ? $blog_2018_query : $blog_2016_query);
	$query->bind_param("i", $post_id);
	$query->execute();
	$res = $query->get_result();

	$photos = [];
	$base_path = $config['database_format_version'] == '2018' ? $config['2018_photos_base_path'] : '';
	while($row = $res->fetch_assoc()){
		$photo = array(
			"location" => $base_path . $row["location"],
			"description" => $row["description"]
			);
		$photos[] = $photo;
	}
	return $photos;
}

function get_comments($sql, int $post_id) : array {
	global $config;

	$blog_2016_query = "SELECT name, date_format(date,'%D %M %Y') AS date, text FROM comments WHERE post_id=? ORDER BY date";
	$blog_2018_query = "
		SELECT c.name as name, date_format(c.created_at,'%D %M %Y') AS date, c.comment as text
		FROM comments c
		INNER JOIN photos p on c.photo_id = p.id
		WHERE p.post_id=? ORDER BY c.created_at
	";

	$query = $sql->prepare($config['database_format_version'] == '2018' ? $blog_2018_query : $blog_2016_query);
	if(!$query){
		die($sql->error);
	}
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
	global $config;

	$blog_2016_query = "SELECT id, title, date_format(date,'%D %M %Y') AS date FROM posts ORDER BY id DESC LIMIT ?, ?";
	$blog_2018_query = "SELECT id, title, date_format(date,'%D %M %Y') AS date FROM posts ORDER BY posts.date DESC LIMIT ?, ?";

	$query = $sql->prepare($config['database_format_version'] == '2018' ? $blog_2018_query : $blog_2016_query);
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