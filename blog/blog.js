$(function(){
	$(".comment_send").click(function(e){
		send_comment($(e.target));
	});

	var nr_posts = parseInt($(".nr_posts").html());

	var offset = 10;

	var current_start = nr_posts;
	var current_end = nr_posts-offset;

	var blog_content = $(".posts");
	var temp_content = $(".temp");

	
	$(".more_button").click(function(){
		
	});
});

function load(current_start, current_end, object, callback){
	$.post("PostsRange.php", {start_id: current_start, end_id: current_end})
		.done(function(data){
			object.append(data);
			callback();
		});
}

