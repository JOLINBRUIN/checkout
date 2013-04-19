

<?php

$q=$_GET["scan"];


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

	// find by barcode
	$result = mysql_query("SELECT * FROM barcode WHERE scan = '".$q."'") or die(mysql_error());
	
	$num_row = mysql_num_rows($result);
	
	//echo $num_row;
	
	
	if ($num_row != 0) 
	{
		while($row = mysql_fetch_array($result))
		{
			$laptop_label = $row['label'];
		}
		$laptop_barcode=$q;
	}
	else {
		// find by equipment ID
		$result = mysql_query("SELECT * FROM barcode WHERE label = '".$q."'") or die(mysql_error());
	
		$num_row = mysql_num_rows($result);
		
		if ($num_row != 0)
		{
			while($row = mysql_fetch_array($result))
			{
				$laptop_barcode = $row['scan'];
			}
			$laptop_label=$q;
			
		}
		
		else
		{
		
			echo 'Invalid Barcode';
			$success=0;
		
		}
		
		
		
	}// end of if num != 0

	

		
		
	if ( $laptop_label != "" ){
		
	echo '<table align="center" cellpadding="20"><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr>';


		
		// find equipment status
		$result = mysql_query("SELECT * FROM status WHERE label = '".$laptop_label."'") or die(mysql_error());
		
		while($row = mysql_fetch_array($result))
		{
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$status = $row['status'];
			$type = $row['type'];
		}
		
		//echo $status." ".$firstname." ".$lastname." ".$type;
		
		//*************************************************************
		// if equipment is AVAILABLE then add to place holder table
		//*************************************************************	
		if ($status == 'AVAILABLE')
		{
			
			// check see if the equipment already exist in the placement holder table
			$result = mysql_query("SELECT * FROM placeholder WHERE label = '".$laptop_label."'") or die(mysql_error());
			$num_row = mysql_num_rows($result);
			
			if($num_row == 0)
			{
				mysql_query("INSERT INTO placeholder(lastname, firstname, type, label, barcode, timestamp) VALUES('','','".$type."', '".$laptop_label."', '".$laptop_barcode."','".$now."')") or die(mysql_error());
				
			}
			
		
		}

		//*************************************************************************************************************************
		// if equipment is OUT then the equipment is a return so log and mark AVAILABLE on status table
		//*************************************************************************************************************************		

		elseif ($status == 'OUT')
		{

			// insert to log table
			mysql_query("INSERT INTO log(type, label, scancode, lastname, firstname, status, timestamp) VALUES('".$type."', '".$laptop_label."', '".$laptop_barcode."', '".$lastname."', '".$firstname."', 'IN', '".$now."')") or die(mysql_error());
			
			
			// erase status table
			mysql_query("UPDATE status SET firstname='', lastname='', location='', timestamp_return='".$now."', status='AVAILABLE' WHERE label = '".$laptop_label."'") or die(mysql_error());			
			
		}
		//*******************************************************************************************
		// if equipment is something else then it can't be checked out or returned.
		//*******************************************************************************************

		else
		{
			echo 'Equipment in use; not available for checkout or return';
		}
		
		echo 'Success';
		$success=1;
	}

	
mysql_close($con);
header('Refresh: 0; url=console.php');

echo '</tr></table>';
?>


