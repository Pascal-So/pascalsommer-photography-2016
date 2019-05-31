<?php
/*
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/
include_once("PostFunctions.php");
include_once("sqlConfig.php");

class Post {

	public $id;

	private $title;
	private $date;

	private $photos;
	private $comments;

	public function __construct(int $id, string $title, string $date){
		$this->id = $id;
		$this->title = $title;
		$this->date = $date;
		$this->photos = array();
		$this->comments = array();
	}

	public function load_photos_and_comments($sql){
		$this->comments = get_comments($sql, $this->id);
		$this->photos = get_photos($sql, $this->id);
	}

	public function view() : string {
		$nr_comments = count($this->comments);
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
		$out.=     "<h3 class='post_title'>{$this->title}</h3>";
		$out.=     "<h5>{$this->date}</h5>";
		$out.=     format_photos($this->photos);
		$out.=     "<h5 class='comments_toggle'>{$toggle_comments_string}</h5>";
		$out.=     "<div class='comments_block hidden'>";
		$out.=         "<div class='post_id hidden'>{$this->id}</div>";
		$out.=         "<div class='comments'>";
		$out.=             format_comments($this->comments);
		$out.=         "</div>";
		$out.=         "<form class='comment comment_new'>";
		$out.=             "<h4 class='comment_name'>New comment</h4>";
		$out.=             "<input type='text' class='comment_input comment_input_name text_input' placeholder='Name'><br>";
		$out.=             "<textarea class='comment_input comment_input_text text_input' placeholder='Message'></textarea><br>";
		$out.=             "<input type='button' value='SEND' class='comment_send comment_input'><br>";
		$out.=         "</form>";
		$out.=     "</div>";
		$out.= "</div>";

		return $out;
	}
}


function getRange(int $skip_nr, int $amount) : string {
	global $sql_host, $sql_username, $sql_password, $sql_database;

	$sql = new mysqli($sql_host, $sql_username, $sql_password, $sql_database);
	$sql->set_charset('utf8');

	$query = $sql->prepare("SELECT id, title, date_format(date,'%D %M %Y') AS date FROM posts ORDER BY id DESC LIMIT ?, ?");
	$query->bind_param("ii", $skip_nr, $amount);
	$query->execute();
	$query_result = $query->get_result();

	$out = "";

	while($post_data = $query_result->fetch_assoc()){
		$post = new Post($post_data['id'], $post_data['title'], $post_data['date']);
		$post->load_photos_and_comments($sql);
		$out .= $post->view();
		$out .= "\n";
	}

	return $out;
}

?>