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

	$.post( "PostComment.php", { name: namefield.val(), text: textfield.val() })
		.done(function( data ) {
			button_object.parent().siblings(".comments").html(data);
		});
}