var currentPic = 1;
var forward = true;

function padLeft(number, len){
	var tmp = number.toString();
	var fill = len-tmp.length;
	var attach = "";
	for(var i = 0; i < fill; i++){
		attach+="0";
	}
	return attach + tmp;
}

function next(picNumber){
	return picNumber%12 + 1;
}

function previous(picNumber){
	return (picNumber+10)%12 + 1;
}

function setPic(picNumber){
	var pathString = "img/pic" + padLeft(picNumber, 2) + ".jpg";
	$('#picview').css("background-image", "url(" + pathString + ")");
	if(forward){
		preloadPic(next(picNumber));
	}else{
		preloadPic(previous(picNumber));
	}
}

function preloadPic(picNumber){
	var pathString = "img/pic" + padLeft(picNumber, 2) + ".jpg";
	$('#preload').css("background-image", "url(" + pathString + ")");	
}

$(function(){
	$('.thumbnail').click(function(e){
		$('#picview').show();
		forward = true;
		currentPic = parseInt(e.target.id);
		setPic(currentPic);
	});

	$('#forwardButton').click(function(e){
		forward = true;
		currentPic= next(currentPic);
		setPic(currentPic);
	});

	$('#backwardButton').click(function(e){
		forward = false;
		currentPic = previous(currentPic);
		setPic(currentPic);
	});

});
