<?php
/*
header ("X-XSS-Protection: 0");

// Is there any input?
if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
	// Get input
	$name = str_replace( '<script>', '', $_GET[ 'name' ] );

	// Feedback for end user
	$html .= "<pre>Hello ${name}</pre>";
}
*/

//以下修正済み
header ("X-XSS-Protection: 0");

// Is there any input?
if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
	// Get input
	$name = str_replace( '<script>', '', $_GET[ 'name' ] );

	//HTML特殊文字をエスケープ処理
	$name = htmlspecialchars($name, ENT_QUOTES, "UTF-8");

	// Feedback for end user
	$html .= "<pre>Hello ${name}</pre>";
}
?>