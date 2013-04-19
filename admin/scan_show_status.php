<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>


<?php

$type = $_GET['type'];

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
	
	if (isset($type))
	{
		$result = mysql_query("SELECT * FROM status WHERE type='".$type."'") or die(mysql_error());
	}
	else
	{
		$result = mysql_query("SELECT * FROM status") or die(mysql_error());
	}
	$fields_num = mysql_num_fields($result);
	
	echo "<div id='onchangelisting'><table border='1' cellpadding='5' class='altrowstable' align='center' id='showtable'><tr>";
	// printing table headers
	for($i=0; $i<$fields_num; $i++)
	{
		$field = mysql_fetch_field($result);
		
		
		if($field->name == 'type')
		{
			echo '<th><select id="type" onchange="javascript:changeType();">
			  		<option value="">'.$field->name.'</option>
			  		<option value="laptop">laptop</option>
			 		<option value="ipad">ipad</option>

					</select></th>';
		}
		else
		{
			echo "<th>{$field->name}</th>";
		}
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
			
				
					echo "</tr>\n";
					$i++;
			}
			echo "</table>";
		}

	mysql_close();

	
?>

<script>

function changeType()
{
	var $t = document.getElementById('type').value;
	$("#onchangelisting").load("scan_show_status.php?type="+$t);
}

</script>