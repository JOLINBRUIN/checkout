<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<?php

$timestamp = strtotime("now");
$now = date('Y-m-d H:i:s', $timestamp);

//*************** add to PLACEHOLDER by Equipment Label ***************//
$equipLabel=$_GET["id"];

//*************** Connection to local mysql database ***************//
	//Include database connection details
	require_once('config.php');
			
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
		
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
//*************** END OF Connection to local mysql database ***************//
	
	// Find Equipment 
	$result = mysql_query("SELECT * FROM status WHERE label = '".$equipLabel."'") or die(mysql_error());
	
	$resultNumRows = mysql_num_rows($result);
	
	if($resultNumRows > 0) //if label is found in the status table then ADD into placeholder Table
	{
		$type = $_POST["type"];
		$type = $_POST["equipid"];
		$type = $_POST["type"];
		
		mysql_query("INSERT INTO placeholder(lastname, firstname, type, label, barcode, timestamp) VALUES('','','".$type."', '".$laptop_label."', '".$laptop_barcode."','".$now."')") or die(mysql_error());
		
		
	}
	else
	{
		echo "Invalid Equipment ID";	
	}

	

?>
</body>
</html>
