<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' )
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<div class="heading_box">
  <h3><i class="fas fa-book"></i> Delete Admins</h3></div>
<?php
if (isset($_GET['admin_id']) && is_numeric($_GET['admin_id']))
{
$admin_id = $_GET['admin_id'];
$result = mysqli_query($conn, "DELETE FROM admins WHERE admin_id=$admin_id")
or die(mysqli_error($conn)); 
echo("<script>location.href = 'index.php?admin&page=admins';</script>");
}
else
{
echo("Admin could not be deleted.");
}
?>
<?php
}
?>
