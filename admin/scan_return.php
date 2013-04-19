<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CRESST Center Equipment Checkout</title>
</head>


<?php

$laptop_label="";
$firstname="";
$lastname="";
$type="";

$r=$_GET["r"];

$timestamp = strtotime("now");
$now = date('Y-m-d H:i:s', $timestamp);

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

	
	$result = mysql_query("SELECT * FROM barcode WHERE scan = '".$r."'") or die(mysql_error());

	$num_record = mysql_num_rows($result);
	
	//echo $num_record."<br>";
	
	if ($num_record != 0)
	{
	
		while($row = mysql_fetch_array($result))
		 {
			$laptop_label = $row['label'];
		 }
		
		// check status table for firstname lastname
		$result = mysql_query("SELECT * FROM status WHERE label = '".$laptop_label."'") or die(mysql_error());
		
		$num_record = mysql_num_rows($result);
		
		if ($num_record != 0)
		{
			while($row = mysql_fetch_array($result))
			 {
				$firstname = $row['firstname'];
				$lastname = $row['lastname'];
				$type = $row['type'];
			 }
			
		}
		
		//echo $firstname." ".$lastname." ".$type;
		
		// insert to log table
		mysql_query("INSERT INTO log(type, label, scancode, lastname, firstname, status, timestamp) VALUES('".$type."', '".$laptop_label."', '".$r."', '".$lastname."', '".$firstname."', 'IN', '".$now."')") or die(mysql_error());
		
		
		// erase status table
		mysql_query("UPDATE status SET firstname='', lastname='', location='', ,timestamp_return='".$now."' status='AVAILABLE' WHERE label = '".$laptop_label."'") or die(mysql_error());
		

	}


mysql_close($con);


?>