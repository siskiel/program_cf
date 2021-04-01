<?php
 //setting default timezone
 date_default_timezone_set('Asia/Jakarta');

 session_start();
 
 //koneksi
	// $db_host	= "localhost";
	// $db_user	= "root";
	// $db_password	= "";
	// $db_name		= "database_yola";

	$koneksi = new mysqli("localhost","root","","database_cf");

	if(mysqli_connect_errno()) {
		echo (mysqli_connect_error());
	}

	//fungsi base_url

	
	
	
?>