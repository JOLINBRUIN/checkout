<?php
$q=$_GET["q"];

$con = mysql_connect('localhost', 'inventory', 'puff95');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("equipment_checkout", $con);

$sql="SELECT * FROM barcode WHERE scan = '".$q."'";

$result = mysql_query($sql);

$row = mysql_fetch_array($result) or die(mysql_error());
echo $row['label'];

/*	while($row = mysql_fetch_array($result))
 	 {
	echo $row['label'];
 	 }
*/


mysql_close($con);



?> 


<?php
/*
$code=$_GET["code"];

$host="149.142.253.185"; // Host name
$username="lin"; // Mysql username
$password="johnlin"; // Mysql password
$db_name="test"; // Database name
$tbl_name_1="equipment"; // Table name
$tbl_name_2="checkout"; // Table name

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

mysql_select_db("test", $con);

$sql="SELECT * FROM equipment WHERE scan = '".$code."'";

$result = mysql_query($sql);


echo "<table border='1'>
<tr>
<th>Scan Code</th>
<th>CRESST Label</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $code . "</td>";
  echo "<td>" . $row['label'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);


/*

// get data that sent from form
$scan=$_POST['scan'];
$id=$_POST['id'];
$user=$_POST['user'];



$sql="INSERT INTO $tbl_name_2(equipment, scancode, user)VALUES('$scan', '$id', '$user')";
$result=mysql_query($sql);


if($result){
echo "Successful<BR>";
echo "<a href=main_forum.php>View your topic</a>";
}
else {
echo "ERROR";
}
mysql_close();*/
?>