<?php
if(is_dir("install/"))
{
echo "<span style='color:red;'>
<i class='fa fa-times-circle'></i> Install Folder Detected please delete it for security reasons.
</span>";
}
?>
<style>
#my-table{width:100%;} /*or whatever width you want*/
#my-table td{width:25%;} /*something big*/
</style>
<p><?php
$sqldb = 
$result = mysqli_query($conn, "SELECT * FROM servers");
$num_rows = mysqli_num_rows($result);
if($num_rows > 0)
{
?>
<?php
$data = mysqli_query($conn, "SELECT * FROM servers ORDER BY server_name ASC")
or die(mysqli_error());
while($row = mysqli_fetch_array( $data ))
{ 
?>              
<table border="0" align="center" id="my-table" style="border: 1px solid #eeeeee;">
<tr>
<td width="15%"><i class="fas fa-server"></i></td>
<td><p><?php echo $row['server_name'] ?></p></td>
<td>
 <?php 
$ip = $row['server_ip'];
$port = $row['server_port'];
if ($sock =! @fsockopen($ip, $port, $num, $error, 5)) 
echo '<img src="images/servers/offline.png" alt="" width="16" height="16" />';
else{
echo '<img src="images/servers/online.png" alt="" width="16" height="16" />';
}  
?>
</td>
<td><?php echo "<img src='images/flags/" . $row['server_location'] . ".png' alt='img'>"; ?></td>
</tr>
</table>
<?php
}
}
else
{
echo "No Servers in the database.";
}
?>

