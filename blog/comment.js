function send_comment(button_object){
	var namefield = button_object.siblings(".comment_input_name");
	var textfield = button_object.siblings(".comment_input_text");

	namefield.removeClass("error");
	textfield.removeClass("error");

	error = false;

	if(namefield.val() == ""){
		error = true;
		namefield.addClass("error");
	}
	if(textfield.val() == ""){
		error = true;
		textfield.addClass("error");	
	}

	if(error){
		return;
	}


	var par = button_object.parent();
	var post_id = parseInt(par.siblings(".post_id").html());

	console.log(post_id);
	$.post( "PostComment.php", { name: namefield.val(), text: textfield.val(), pid: post_id })
		.done(function( data ) {
			
			par.siblings(".comments").html(data);
		});
}