<?php

function invalid_request(){
	http_response_code(400);
	exit();
}

?>