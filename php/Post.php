<?php
/*
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/
include("../php/PostFunctions.php");

class Post {

	public $id;

	private $title;
	private $date;

	private $photos;
	
	private $comments;
	
	private $nr_comments;

	public function __construct($id){
		$this->id = $id;
		$this->photos = array();
		$this->comments = array();
	}

	public function load($sql){
		$res = $sql->query("select title, date_format(date,'%D %M %Y') as date from posts where id=" . $this->id);
		if($res->num_rows == 0){
			return false;
		} 

		$row = $res->fetch_assoc();
		$this->title = $row["title"];
		$this->date = $row["date"];

		$this->photos = get_photos($sql, $this->id);

		$this->comments = get_comments($sql, $this->id);

		$this->nr_comments = count($this->comments);

		return true;
	}

	public function view(){
		$toggle_comments_string;
		switch($this->nr_comments){
			case 0:
				$toggle_comments_string = "no comments yet";
				break;
			case 1:
				$toggle_comments_string = "1 comment";
				break;
			default:
				$toggle_comments_string = "{$this->nr_comments} comments";
		}

		$out = "<div class='post'>";
		$out.=     "<h3 class='post_title'>{$this->title}</h3>";
		$out.=     "<h5>{$this->date}</h5>";
		$out.=     format_photos($this->photos);
		$out.=     "<h5 class='comments_toggle'>{$toggle_comments_string}</h5>";
		$out.=     "<div class='comments_block'>";
		$out.=         "<div class='comments'>";
		$out.=             format_comments($this->comments);
		$out.=         "</div>";
		$out.=         "<form class='comment comment_new'>";
		$out.=             "<h4 class='comment_name'>New comment</h4>";
		$out.=             "<input type='text' class='comment_input text_input' placeholder='Name' name='name'><br>";
		$out.=             "<textarea name='text' class='comment_input comment_input_text text_input' placeholder='Message'></textarea><br>";
		$out.=             "<input type='button' value='SEND' class='comment_send comment_input'><br>";
		$out.=         "</form>";
		$out.=     "</div>";
		$out.= "</div>";

		return $out;
	}
}

?>