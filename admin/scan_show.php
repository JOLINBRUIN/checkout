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

$table = $_GET['t'];


	
	// sending query
	if ($table == 'log')
	{
		$result = mysql_query("SELECT * FROM log ORDER BY id DESC") or die(mysql_error());
	}
	else
	{
		$result = mysql_query("SELECT * FROM ".$table) or die(mysql_error());
	}
	
	$fields_num = mysql_num_fields($result);
	
	echo "<table border='1' cellpadding='5' class='altrowstable' align='center' id='showtable'><tr>";
	// printing table headers
	for($i=0; $i<$fields_num; $i++)
	{
		$field = mysql_fetch_field($result);
		echo "<th>{$field->name}</th>";
	}
	echo "</tr>\n";
	
		$count = mysql_num_rows($result);
		
		if($count == 0)
		{
			echo "<tr><td colspan='".$fields_num."' align='center'> <p><br><br><br>No Records<br><br><br></p> </td></tr>";
		}
		else
		{	
	
			// printing table rows
			$i=0;
			while($row = mysql_fetch_row($result))
			{
				if( $i % 2 == 0 )
				{
					echo "<tr class='evenrowcolor'>";
				}
				else
				{
					echo "<tr class='oddrowcolor'>";
				}	
				// $row is array... foreach( .. ) puts every element
				// of $row to $cell variable
				
				if ($table == status)
				{
					foreach($row as $key=>$cell)
					{		
						if($key==11)
						{
							if($cell == 'AVAILABLE')
							{
								echo "<td style='background-color:#00ff00; text-align:center;'>$cell</td>";
							}
							else
							{
								echo "<td style='background-color:red; text-align:center;'>$cell</td>";
							}
						}
						else
						{
							echo "<td>$cell</td>";
						}
					}
				}
				else
				{
					foreach($row as $cell)
					{		
						echo "<td>$cell</td>";
					}
				}
				
					echo "</tr>\n";
					$i++;
			}
			echo "</table>";
		}

	mysql_close();

	/*while($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		foreach($row as $cell)
		{
			echo "<td>$cell</td>";	
		}
		echo "</tr>";
	}
	
	echo "</table>";*/
	
	//$fields_num = mysql_num_fields($result);
	
	// printing table headers
	/*echo "<table border='1' cellpadding='5' class='altrowstable' align='center'><tr><th></th><th>Index</th><th>Last Name</th><th>First Name</th><th>Type</th><th>Equipment ID</th><th>Bar Code</th><th>Time Stamp</th></tr>\n";

		// printing table rows
		$i=0;
		while($row = mysql_fetch_row($result))
		{
			if( $i % 2 == 0 )
			{
				echo "<tr class='evenrowcolor'>";
			}
			else
			{
				echo "<tr class='oddrowcolor'>";
			}
			
			echo "<td><a href='javascript:del(".$row[0].")'>Delete</a></td>";
			
			// $row is array... foreach( .. ) puts every element
			// of $row to $cell variable
			foreach($row as $key=>$cell)
			{
				if ($key == 2)
				{
					echo "<td><input type='text' name='firstname".$i."' value='$cell' /></td>";
				}
				elseif ($key == 1)
				{
					echo "<td><input type='text' name='lastname".$i."' value='$cell' /></td>";
				}
				elseif ($cell == "")
				{
					if ($key == 3)
					{
						echo "<td><input type='text' name='equipmentid".$i."' value='$cell' /></td>";	
					}
					elseif ($key == 4)
					{
						echo "<td><input type='text' name='barcode".$i."' value='$cell' /></td>";
					}
					
				}
				else
				{
					echo "<td>$cell</td>";	
				}
			}
			echo "</tr>\n";
			$i++;
		}
	
		
		echo "<tr><td colspan='9' align='center'><a class='cssbtn' href='javascript:submits()'>Submit</a></td></tr></table>";
	mysql_free_result($result);*/
	

	
?>