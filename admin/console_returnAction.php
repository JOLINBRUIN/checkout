<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<?php

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



$timestamp = strtotime("now");
$now = date('Y-m-d H:i:s', $timestamp);



//*************** add to PLACEHOLDER by Equipment Label ***************//
// add to placeholder table
// update status table into unavailable

$type=$_GET["t"];
$equipLabel=$_GET["l"];
$barcode1=$_GET["b"];

	// Make sure equipment label exist	
	$result = mysql_query("SELECT * FROM status WHERE label = '".$equipLabel."'") or die(mysql_error());
	
	$resultNumRows = mysql_num_rows($result);
	
	// if placeholder table already exist
	
	if($resultNumRows > 0) //if label is found then ADD into placeholder Table
	{
		//$type = $_POST["type".$indx];
		//$barcode1 = $_POST["barcode1".$indx];
		
		// check for duplicates on placeholder/pending table
		$checkExist = mysql_query("SELECT * FROM placeholder WHERE label = '".$equipLabel."'") or die(mysql_error());
		
		$checkNumRows = mysql_num_rows($checkExist);
		
		if($checkNumRows == 0)
		{
			if($type == "") 
			{
				$type = " - ";
			}
			elseif ($barcode1 == "")
			{
				$barcode1 = " - ";
			}
			
			mysql_query("INSERT INTO placeholder(lastname, firstname, type, label, barcode, timestamp) VALUES('','','".$type."', '".$equipLabel."', '".$barcode1."','".$now."')") or die(mysql_error());
			
			$returnMsg = "Successful";
			
		}
		else
		{
			$returnMsg = "Equipment already exist in the Pending table";
		}
		
	}
	else
	{
		$returnMsg = "Invalid Equipment ID";	
	}

	
	echo $returnMsg;
	
?>
</body>
</html>
