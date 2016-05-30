$(function(){
	addPostHandlers();
	var nr_posts = parseInt($(".nr_posts").html());
	var offset = parseInt($(".block_size").html());
	var current_start = parseInt($(".next_start").html());
	var current_end = current_start-offset+1;

	var blog_content = $(".posts");
	//var temp_content = $(".temp");

	
	$(".more_button").click(function(){
		load(current_start, current_end, blog_content);
		current_start = current_end-1;
		current_end = current_start-offset+1;
		if(current_start<=0){
			$(".more_button").addClass("hidden");
		}
	});
});

function load(current_start, current_end, object){
	$.post("PostsRange.php", {start_id: current_start, end_id: current_end})
		.done(function(data){
			object.append(data);
			addPostHandlers();
		});
}

function addPostHandlers(){
	$(".fresh .comment_send").click(function(e){
		send_comment($(e.target));
	});
	$(".fresh .comments_toggle").click(function(e){
		toggle_comments($(e.target));
	});
	$(".fresh").removeClass("fresh");
}