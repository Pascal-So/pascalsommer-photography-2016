<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);


include_once("sqlConfig.php");
include_once("Post.php");

$sql = new mysqli($sql_host, $sql_username, $sql_password, $sql_database);
$res = $sql->query("SELECT count(*) AS nr_posts FROM posts");
$nr_posts = intval($res->fetch_assoc()["nr_posts"]);

$posts_per_request = 10;
if(isset($_GET['count'])){
	$in= intval($_GET['count']);
	if($in>0){
		$posts_per_request = $in;
	}
}

?>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">


  	<link href='https://fonts.googleapis.com/css?family=Advent+Pro:400,700' rel='stylesheet' type='text/css'>

	<title>
		Pascal Sommer
	</title>

	<link rel="stylesheet" type="text/css" href="../base.css">
	<link rel="stylesheet" type="text/css" href="content.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script src="blog.js"></script>
	<script src="comment.js"></script>


</head>
<body>
<header>
	<div id="titleBar">
		<h1>PASCAL SOMMER</h1>
		<h3>PHOTOGRAPHY</h3>
	</div>
	<nav>
		<a href="../#work">WORK</a>
		<a href="../#about">ABOUT ME</a>
		<a href="#blog">BLOG</a>
	</nav>
</header>


<section id="blog">
	<div class="nr_posts hidden"><?= $nr_posts ?></div>
	<div class="posts_per_request hidden"><?= $posts_per_request ?></div>
	<div class="temp hidden"></div>
	<div class="posts">
		<?= getRange(0, $posts_per_request) ?>
	</div>

	<h4 class="hidden">Loading pictures...</h4>
	<input type="button" class="more_button <?php if($count >= $nr_posts){echo 'hidden';} ?>" value="SHOW OLDER CONTENT">
</section>


<footer>
	<div id="copyrightInfo">
		<p>Copyright</p>
		<h4>PASCAL SOMMER 2016</h4>
	</div>
</footer>

</body>
</html>
