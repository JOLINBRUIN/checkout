<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>


<?php

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
	
	
	// sending query
	$result = mysql_query("SELECT * FROM status WHERE status='AVAILABLE'") or die(mysql_error());

/*echo "<table>";
	while($row = mysql_fetch_array($result))
	{
		echo "<tr>";
		echo "<td>" . $row['label'] . "</td>";
		echo "<td>" . $row['barcode1'] . "</td>";
		echo "</tr>";
	}

echo "</table>";*/

	//$fields_num = mysql_num_fields($result);
	
	echo "<form id='formAdd' name='formAdd' method='post' action='console_addAction.php' >";
	
	// printing table headers
	echo "<table border='1' cellpadding='5' class='altrowstable' align='center'><tr><th>Index</th><th>Add</th><th>Type</th><th>Equipment ID</th><th>Barcode 1</th><th>Status</th></tr>\n";

		// printing table rows
		
		$count = mysql_num_rows($result);
		
		if($count == 0)
		{
			echo "<tr><td colspan='8' align='center'> <p><br><br><br>No Records<br><br><br></p> </td></tr>";
		}
		else
		{
			$i=1;
			while($row = mysql_fetch_array($result))
			{
				if( $i % 2 == 0 )
				{
					echo "<tr class='evenrowcolor'>";
				}
				else
				{
					echo "<tr class='oddrowcolor'>";
				}
				
				echo "<td>$i</td>";
				echo "<td><a href='javascript:add(\"".$row['type']."\", \"".$row['label']."\", \"".$row['barcode1']."\")'>Add</a></td>";
				echo "<td>" . $row['type'] . "</td><input type='hidden' name='type".$i."' value='".$row['type']."' />";
				echo "<td>" . $row['label'] . "</td><input type='hidden' name='label".$i."' value='".$row['label']."' />";
				echo "<td>" . $row['barcode1'] . "</td><input type='hidden' name='barcode1".$i."' value='".$row['barcode1']."' />";
				echo "<td>" . $row['status'] . "</td>";
				echo "</tr>\n";
				$i++;
			}
		
		
		echo "</table></form>";
	
		} // end of count == 0
	
	mysql_close();
	
	//echo '</form>';
	
?>