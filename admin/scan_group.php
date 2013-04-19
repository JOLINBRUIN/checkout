<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>


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
	
	
	// sending query
	$result = mysql_query("SELECT * FROM placeholder") or die(mysql_error());
	
	//$fields_num = mysql_num_fields($result);

	echo '<form id="form1" name="form1" method="post" action="scan_group_submit.php" >';


	// printing table headers
	
	$fields_num = mysql_num_fields($result);
	
	echo "<table border='1' cellpadding='5' class='altrowstable' align='center'><tr><th></th><th></th>";
	// printing table headers
	for($i=0; $i<$fields_num; $i++)
	{
		$field = mysql_fetch_field($result);
		echo "<th>{$field->name}</th>";
	}
	echo "</tr>\n";	
	
	//echo "<table border='1' cellpadding='5' class='altrowstable' align='center'><tr><th></th><th></th><th>Index</th><th>Last Name</th><th>First Name</th><th>Type</th><th>Equipment ID</th><th>Bar Code</th><th>Time Stamp</th></tr>\n";

		// printing table rows
		
	$count = mysql_num_rows($result);
		
	if($count == 0)
	{
		echo "<tr><td colspan='".$fields_num."' align='center'> <p><br><br><br>No Records<br><br><br></p> </td></tr>";
	}	
	else
	{
		echo "<tr><td></td><td><span style='font-size:9px;'><a href='javascript:checkall(".$count."')>check</a></span></td><td></td><td align='center'><span style='font-size:9px;'><a href='javascript:copylname(".$count."')>Copy all</a></span></td><td align='center'><span style='font-size:9px;'><a href='javascript:copyfname(".$count."')>Copy all</a></span></td><td></td><td></td><td></td><td></td></tr>";
		
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
			
			echo "<td><a href='javascript:del(".$row[0].")'>Delete</a></td><td><input type='checkbox' name='checkbox".$i."' value='1'  checked /></td>";
			
			// $row is array... foreach( .. ) puts every element
			// of $row to $cell variable
			foreach($row as $key=>$cell)
			{
				if ($key == 0)
				{
					echo "<td>".$cell."<input type='hidden' name='index".$i."' id='index".$i."' value='".$cell."'></td>";
				}
				elseif ($key == 1)
				{
					echo "<td><input type='text' name='lastname".$i."' id='lastname".$i."' value='".$cell."' /></td>";
				}
				elseif ($key == 2)
				{
					echo "<td><input type='text' name='firstname".$i."' id='firstname".$i."' value='".$cell."' /></td>";
				}
				elseif ($key == 3)
				{
					echo "<td>".$cell."<input type='hidden' name='type".$i."' id='type".$i."' value='".$cell."' /></td>";	
				}				
				elseif ($key == 4)
				{
					echo "<td>".$cell."<input type='hidden' name='eqid".$i."' id='eqid".$i."' value='".$cell."' /></td>";	
				}
				elseif ($key == 5)
				{
					echo "<td>".$cell."<input type='hidden' name='barcode".$i."' id='barcode".$i."' value='".$cell."' /></td>";
				}
					
				elseif ($key == 6)
				{
					echo "<td>".$cell."<input type='hidden' name='time".$i."' id='time".$i."' value='".$cell."' /></td>";
				}

			}
			echo "</tr>\n";
			$i++;
		}
	
		
		echo "<tr><td colspan='9' align='center'><a class='cssbtn' href='javascript:submits()'>Checkout</a></td></tr></table>";
		mysql_free_result($result);
	
	}
	
	mysql_close();
	
?>