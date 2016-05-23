<?php

function invalid_request(){
	http_response_code(400);
	exit();
}

function abort(){
	exit();
}

function stripNewlines($string){
	$string = str_replace("\n\r", "<br>", $string);
	$string = str_replace("\r\n", "<br>", $string);
	$string = str_replace("\n", "<br>", $string);
	$string = str_replace("\r", "<br>", $string);
	return $string;
}

?>