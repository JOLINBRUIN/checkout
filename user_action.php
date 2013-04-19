<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php

// retrieve variable and make sure all the spaces are taken out so the string would match
$fname = $_POST['fname'];
$fname = trim($fname);
$fname = strtolower($fname);
$fname = ucfirst ($fname);
$lname = $_POST['lname'];
$lname = trim($lname);
$lname = strtolower($lname);
$lname = ucfirst ($lname);
$count = $_POST['count'];

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
	

	// if only one matching equipment, the height of the checkout table can be at its orginal length
	if ($count == 1)
	{
		// add to log table
		$result = mysql_query("INSERT INTO log(type, label, scancode, lastname, firstname, status, timestamp) VALUES('".$_POST['type']."', '".$_POST['eqid']."', '".$_POST['barcode']."', '".$lname."', '".$fname."', 'OUT', '".$now."')")or die(mysql_error());
			
		// remove from placeholder table
		$result = mysql_query("DELETE FROM placeholder WHERE id='".$_POST['index']."'")or die(mysql_error());

		// update equipment status
		mysql_query("UPDATE status SET firstname='".$fname."', lastname='".$lname."', status='OUT', timestamp_out='".$now."' WHERE label='".$_POST['eqid']."'")or die(mysql_error());
			
	}

	// if more item found, checkboxes will be available for users to check on. 
	elseif ($count > 1)
	{
		//remove multiple items with checkboxes checked
		for($i=0; $i<$count; $i++)
		{

			$checkboxname='checkbox'.$i;
			
			if( $_POST[$checkboxname] == 1)
			{
				// add to log table
				$type='type'.$i;
				$eqid='eqid'.$i;
				$barcode='barcode'.$i;
				$index='index'.$i;
				$result = mysql_query("INSERT INTO log(type, label, scancode, lastname, firstname, status, timestamp) VALUES('".$_POST[$type]."', '".$_POST[$eqid]."', '".$_POST[$barcode]."', '".$lname."', '".$fname."', 'OUT', '".$now."')")or die(mysql_error());
								
				// remove from placeholder table
				mysql_query("DELETE FROM placeholder WHERE id='".$_POST[$index]."'")or die(mysql_error());
				
				
				//update equipment status
				mysql_query("UPDATE status SET firstname='".$fname."', lastname='".$lname."', status='OUT', timestamp_out='".$now."', timestamp_return='0000-00-00 00:00:00' WHERE label='".$_POST[$eqid]."'")or die(mysql_error());

			}
			
		}
		
	}
		
		
		
	echo "<div id='successful'>
	<br><br><br><br>
	<p> Your item has been checked out successfully</p>
	<p> Thank you for using our CSE Checkout System </p>

</div>";


mysql_close($con);
header('Refresh: 2; url=user_index.php');
?>


</body>

