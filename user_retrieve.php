<?php 

$firstname=$_GET["f"];
$lastname=$_GET["l"];

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
	$result = mysql_query("SELECT id, type, label, barcode FROM placeholder WHERE firstname='".$firstname."' and lastname='".$lastname."'") or die(mysql_error());
	
	//echo "firstname=".$firstname;
	//echo " lastname=".$lastname;
	
	$count = mysql_num_rows($result);
	
	//echo "count ".$count;
	
	
	// if no matching name is found in the placeholder table
	if ($count == 0)
	{	
		// look for the ones that have no assigned names
		$result = mysql_query("SELECT id, type, label, barcode FROM placeholder WHERE firstname='' and lastname=''") or die(mysql_error());
		
		$count = mysql_num_rows($result);
		
		// if no blank names then no scanned equipments are available
		if ($count == 0 )
		{
			echo "<div align='center'><br>No Equipment Available. Please <a href='javascript:refreshing()'>Refresh</a></div>";	
		}

	}
	// end of $count==0
	
		if ($count == 1)
		{
			echo "<table align='center' class='imagetable' width='450'><tr><th>Type</th><th>Equipment ID</th><th>Barcode</th></tr>";	
			while($row = mysql_fetch_row($result))
				{
				echo "<tr>";
						
					// $row is array... foreach( .. ) puts every element
					// of $row to $cell variable
					foreach($row as $key=>$cell)
					{	
						if($key == 0)
						{
							echo "<input type='hidden' name='index' value='".$row[$key]."'>";
						}
						elseif($key == 1)
						{
							echo "<input type='hidden' name='type' value='".$row[$key]."'>";
							echo "<td>$cell</td>";				
						}
						elseif($key == 2)
						{
							echo "<input type='hidden' name='eqid' value='".$row[$key]."'>";
							echo "<td>$cell</td>";				
						}
						elseif($key == 3)
						{
							echo "<input type='hidden' name='barcode' value='".$row[$key]."'>";
							echo "<td>$cell</td>";				
						}
					}
					echo "</tr>\n";
				}
			
			echo "</table>";
		}
		elseif ($count > 1)
		{
			echo "<table align='center' class='imagetable' width='450'><tr><th> </th><th>Type</th><th>Equipment ID</th><th>Barcode</th></tr>";
			$i=0;
			while($row = mysql_fetch_row($result))
			{
		
				echo "<tr><td class='clickable'><label><input type='checkbox' name='checkbox".$i."' id='checkbox".$i."' value='1'></label></td>";
					// $row is array... foreach( .. ) puts every element
					// of $row to $cell variable
					foreach($row as $key=>$cell)
					{			
						if($key == 0)
						{
							echo "<input type='hidden' name='index".$i."' value='".$row[$key]."'>";
						}
						elseif($key == 1)
						{
							echo "<input type='hidden' name='type".$i."' value='".$row[$key]."'>";
							echo "<td>$cell</td>";				
						}
						elseif($key == 2)
						{
							echo "<input type='hidden' name='eqid".$i."' value='".$row[$key]."'>";
							echo "<td>$cell</td>";				
						}
						elseif($key == 3)
						{
							echo "<input type='hidden' name='barcode".$i."' value='".$row[$key]."'>";
							echo "<td>$cell</td>";				
						}
					}
					echo "</tr>\n";
				$i++;
			}
			
			
			echo "</table>";
			
		}
		
		echo "<input type='hidden' name='count' id='count' value='".$count."'>";
	
	
		
	
	//echo $row['label'];	
	
	// add equipment to placement holder
	//$result = mysql_query("INSERT INTO placeholder(eq_id, barcode) VALUES('".$row['label']."', '".$q."')") or die(mysql_error());
	




?>


<script> 

var count = <?php echo $count; ?>;

if(count > 1) 
{
	document.getElementById('mainbox').style.height=520+(41*count)+'px';
	document.getElementById('listing').style.height=90+(41*count)+'px';
}

</script>