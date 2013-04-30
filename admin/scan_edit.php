

<?php

$edit=$_GET["edit"];

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

	// find equipment ID
	$result = mysql_query("SELECT * FROM ".$edit) or die(mysql_error());
	
	$num_row = mysql_num_rows($result);
	
	//echo $num_row;
	

	if ($num_row != 0) 
	{

		if ($edit == "status")
		{
			echo '<form id="form1" name="form1" method="post" action="scan_edit_submit.php?table=status" >';
			
			$fields_num = mysql_num_fields($result);
			
			echo "<table border='1' cellpadding='5' class='altrowstable' align='center' id='showtable'><tr>";
			// printing table headers
			for($i=0; $i<$fields_num; $i++)
			{
				$field = mysql_fetch_field($result);
				echo "<th>{$field->name}</th>";
			}
			echo "</tr>\n";

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
					if ($key==6)
					{
						echo "<td><input name='firstname".$i."' value='".$cell."'></td>";
					}
					elseif ($key==7)
					{
						echo "<td><input name='lastname".$i."' value='".$cell."'></td>";
					}
					elseif($key==8)
					{
						echo "<td><select id='location".$i."' name='location".$i."' onchange='javascript:location_dropdown(".$i.");'><option value='".$cell."'>".$cell."</option><option value='PVUB 1400'>PVUB 1400</option><option value='PVUB 1355'>PVUB 1355</option><option value='GSEIS'>GSEIS</option><option value='other'>Other</option></select><p><input id='otherlocation".$i."' name='otherlocation".$i."' value='".$cell."' style='display:none'></p></td>";
					}
					elseif($key==11)
					{
						echo "<td><select id='status".$i."' name='status".$i."' onchange='javascript:status_dropdown(".$i.");'><option value='".$cell."'>".$cell."</option><option value='AVAILABLE'>AVAILABLE</option><option value='OUT'>OUT</option><option value='OUT OF SERVICE'>OUT OF SERVICE</option><option value='other'>Other</option></select><p><input id='otherstatus".$i."' name='otherstatus".$i."' value='".$cell."' style='display:none'></p></td>";
					}
					else
					{
						echo "<td>".$cell."</td>";	
					}
				}

						
				echo "</tr>\n";
				$i++;
			}
			
			echo "<tr><td colspan='".$fields_num."' align='center'><a class='cssbtn' href='javascript:submits()'>Submit</a></td></tr>";
			
				
		} // end of if ($edit == "status")
				
		echo "</table></form>";	
	} // end of if ($num_row != 0) 
	

	
mysql_close();

?>

<script>

function location_dropdown(id)
{
	var str='location'+id;
	var otherstr='otherlocation'+id;
	
	if (document.getElementById(str).value == 'other')
	{
		document.getElementById(otherstr).style.display='block';		
	}
	else
	{
		document.getElementById(otherstr).style.display='none';	
	}
	//alert (document.getElementByName(str).value);
	//if(document.getElementsByName(location+id).value == 'other')
}

function status_dropdown(id)
{
	var str='status'+id;
	var otherstr='otherstatus'+id;
	
	if (document.getElementById(str).value == 'other')
	{
		document.getElementById(otherstr).style.display='block';		
	}
	else
	{
		document.getElementById(otherstr).style.display='none';	
	}
	//alert (document.getElementByName(str).value);
	//if(document.getElementsByName(location+id).value == 'other')
}

</script>