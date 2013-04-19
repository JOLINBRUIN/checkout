<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
#wrapper {
	text-align: center;
}
-->
</style>
</head>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js'></script>

<script>

function show(str)
{
	$('#listing').fadeOut('slow').load('console_log.php?row='+str).fadeIn("slow");
}

</script>

<?php

//*************** show all log - with variable that limit the number show ***************//

$row = $_GET['row'];

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
	if($row == "")
	{
		$result = mysql_query("SELECT * FROM log ORDER BY id DESC LIMIT 50") or die(mysql_error());
	}
	elseif($row =="0")
	{
		$result = mysql_query("SELECT * FROM log ORDER BY id DESC") or die(mysql_error());
	}
	else
	{
		$result = mysql_query("SELECT * FROM log ORDER BY id DESC LIMIT ".$row) or die(mysql_error());
	}
	
	$fields_num = mysql_num_fields($result);

	
	echo "<table border='1' cellpadding='5' class='altrowstable' align='center' id='showtable'><tr><th colspan='".$fields_num;
	echo "'><a href='javascript:show(50);'>50</a> <a href='javascript:show(100);'>100</a> <a href='javascript:show(0)'>All</a></th></tr><tr>";
	
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

			foreach($row as $cell)
			{		
				echo "<td>$cell</td>";
			}
				
				
				echo "</tr>\n";
				$i++;
		}
		echo "</table></div>";
	}
	
	mysql_close();
	
	//echo '</form>';
	
?>