<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CRESST Center Equipment Checkout</title>
</head>


<?php

//$laptop_label="";

$laptop_label = "";
//$q = "1S6475ZJ6R8RR317";
$q=$_GET["q"];


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

$sql="SELECT * FROM barcode WHERE scan = '".$q."'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result) or die(mysql_error());
$laptop_label=$row['label'];

//echo $laptop_label;





//mysql_query("INSERT INTO log (equipment, scancode, firstname, lastname, status) VALUES ('$_POST[eq]','$_POST[scan]', '$_POST[first]','$_POST[last]','$_POST[stat]')") or die(mysql_error());

//$sql="SELECT * FROM log WHERE equipment = '".$laptop_label."'";
$sql="SELECT * FROM log WHERE equipment = '".$laptop_label."' ORDER BY timestamp DESC";
$result = mysql_query($sql);
$row = mysql_fetch_array($result) or die(mysql_error());

if ($row['status'] == 'IN')
{
	echo "ERROR: The equipment hasn't been checked out";	
}
else if ($row['status'] == 'OUT')
{
	echo "Thank you ".$row['firstname']." ".$row['lastname'];

	mysql_query("INSERT INTO log (equipment, scancode, firstname, lastname, status) VALUES ('".$laptop_label."','".$row['scancode']."', '".$row['firstname']."','".$row['lastname']."','IN')") or die(mysql_error());

header('Refresh: 2; url=http://cse-it-g326/pvub/checkout/index.html');

	/* update Jason's database and tag the equipment as available */
	
}
else
{
	echo "ERROR: The equipment does not exist in this database";	
}

mysql_close($con);



?>