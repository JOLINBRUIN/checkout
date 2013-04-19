<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
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
	$result = mysql_query("SELECT id FROM placeholder");
		if (!$result) {
			die("select table failed");
		}

	$i=0;
	while($row = mysql_fetch_row($result))
	{
		$firstname = $_POST['firstname'.$i];
		$lastname = $_POST['lastname'.$i];
		
		mysql_query("UPDATE placeholder SET firstname='".$firstname."', lastname='".$lastname."' WHERE id='".$row[0]."'");
		
		$i++;

	}

	
mysql_close();

header('Location: console.php', true, 302);

?> 

</body>


