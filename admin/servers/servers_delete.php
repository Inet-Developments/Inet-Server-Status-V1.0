<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' )
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<div class="heading_box">
  <h3><i class="fas fa-book"></i> Delete Servers</h3></div>
<?php
if (isset($_GET['server_id']) && is_numeric($_GET['server_id']))
{
$server_id = $_GET['server_id'];
$result = mysqli_query($conn, "DELETE FROM servers WHERE server_id=$server_id")
or die(mysqli_error($conn)); 
echo("<script>location.href = 'index.php?admin&page=servers';</script>");
}
else
{
echo("Server could not be deleted.");
}
?>
<?php
}
?>
