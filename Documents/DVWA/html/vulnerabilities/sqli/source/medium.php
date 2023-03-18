<?php
/*
if( isset( $_POST[ 'Submit' ] ) ) {
	// Get input
	$id = $_POST[ 'id' ];

	$id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $id);

	$query  = "SELECT first_name, last_name FROM users WHERE user_id = $id;";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die( '<pre>' . mysqli_error($GLOBALS["___mysqli_ston"]) . '</pre>' );

	// Get results
	while( $row = mysqli_fetch_assoc( $result ) ) {
		// Display values
		$first = $row["first_name"];
		$last  = $row["last_name"];

		// Feedback for end user
		$html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
	}

}

// This is used later on in the index.php page
// Setting it here so we can close the database connection in here like in the rest of the source scripts
$query  = "SELECT COUNT(*) FROM users;";
$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );
$number_of_rows = mysqli_fetch_row( $result )[0];

mysqli_close($GLOBALS["___mysqli_ston"]);
*/

//以下修正済み
if( isset( $_POST[ 'Submit' ] ) ) {
	// Get input
	$id = $_POST[ 'id' ];
	$count = 0;

	if ( ctype_digit($id) === false ) {
		$html .= "<pre>IDが不正な形式です。</pre>";
		goto db_index;
	}

	try{
		$pdo = new PDO('mysql:dbname=dvwa;host=127.0.0.1', 'app', 'vulnerables');
		$stmt = $pdo->prepare('SELECT first_name, last_name FROM users WHERE user_id = :id');
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$pdo = null;
		$stmt = null;
	}catch(PDOException $e){
		echo "データベースエラー";
		die();
	}

	// Get results
	foreach( $result as $value ) {
		$first = $value[0];
		$last  = $value[1];

		// Feedback for end user
		$html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
	}

}

// This is used later on in the index.php page
// Setting it here so we can close the database connection in here like in the rest of the source scripts
db_index:
$query  = "SELECT COUNT(*) FROM users;";
$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );
$number_of_rows = mysqli_fetch_row( $result )[0];

mysqli_close($GLOBALS["___mysqli_ston"]);
?>
