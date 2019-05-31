$(function(){
	addPostHandlers();
	var nr_posts = parseInt($(".nr_posts").html());
	var posts_per_request = parseInt($(".posts_per_request").html());
	var skip_nr_posts = posts_per_request;

	var blog_content = $(".posts");

	$(".more_button").click(function(){
		load(skip_nr_posts, posts_per_request, blog_content);
		skip_nr_posts += posts_per_request;

		if(skip_nr_posts >= nr_posts){
			$(".more_button").addClass("hidden");
		}
	});
});

function load(skip_nr, amount, object){
	$.post("PostsRange.php", {skip_nr: skip_nr, amount: amount})
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
