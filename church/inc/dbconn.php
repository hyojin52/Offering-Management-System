<?php
	$servername = "localhost";
	$username = "";
	$password = "";
	$dbname = "ubinet2018";


	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	//else
	//	echo "연결됨"

	$conn->query("set session character_set_connection=utf8;");
	$conn->query("set session character_set_results=utf8;");
	$conn->query("set session character_set_client=utf8;");

?>
