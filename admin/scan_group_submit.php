<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php


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

	$result = mysql_query("SELECT id FROM placeholder") or die(mysql_error());

	
	$i=0;
	while($row = mysql_fetch_row($result))
	{	
		$checkbox = $_POST['checkbox'.$i];
		
		if ($checkbox == 1) 
		{

			$fname = $_POST['firstname'.$i];
			$fname = trim($fname);
			$lname = $_POST['lastname'.$i];
			$lname = trim($lname);						
			$type='type'.$i;
			$eqid='eqid'.$i;
			$barcode='barcode'.$i;
			$index='index'.$i;
			
			// add to log table
			$result = mysql_query("INSERT INTO log(type, label, scancode, lastname, firstname, status, timestamp) VALUES('".$_POST[$type]."', '".$_POST[$eqid]."', '".$_POST[$barcode]."', '".$lname."', '".$fname."', 'OUT', '".$now."')")or die(mysql_error());
								
				// remove from placeholder table
				mysql_query("DELETE FROM placeholder WHERE id='".$_POST[$index]."'")or die(mysql_error());
				
				
				//update equipment status
				mysql_query("UPDATE status SET firstname='".$fname."', lastname='".$lname."', status='OUT', timestamp_out='".$now."', timestamp_return='0000-00-00 00:00:00' WHERE label='".$_POST[$eqid]."'")or die(mysql_error());

			
		}
		
		
		$i++;

	}

	
mysql_close();

header('Location: console.php', true, 302);

?> 

</body>


