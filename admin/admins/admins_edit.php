<?php
// If signed in and admin level is Admin
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' )
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<script type="text/javascript" src="includes/tiny/js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
selector: 'textarea',  // change this value according to your HTML
height: 200,
plugins: [
'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'emoticons'
],
toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
'forecolor backcolor emoticons | help',
a_plugin_option: true,
a_configuration_option: 400
});
</script>
<div class="heading_box">
<?php
$admin_id = $_GET['admin_id'];
$result = mysqli_query($conn, "SELECT * FROM admins WHERE admin_id = $admin_id")
or die(mysqli_error($conn)); 
$row = mysqli_fetch_array($result);
{
?>
<h3><i class="fas fa-edit"></i> <b>Edit account for <?php echo $row['admin_username'] ?></b></h3></div>
<?php
if (isset($_POST['update_account'])) {

if(!empty($_POST['admin_email'])
&&
!empty($_POST['admin_password']))	

$admin_email = $_POST['admin_email'];
$admin_password = $_POST['admin_password'];

mysqli_query($conn, "Update admins
SET 
admin_email = '$admin_email',
admin_password = '$admin_password'

WHERE 
admin_id = '$admin_id'");

echo '<div class="success-msg">
<p><i class="fa fa-check-circle"></i>
Admin '. $row['admin_username'] .' has been updated. <a href="index.php?admin&page=admins">Return to Admin Management.</a>
</div>';
}
}
?>

<form name="form1" method="post" action="">
<table width="100%" border="0">
<tr>
<td width="20%"><h3>Edit Account Email</h3></td>
</tr>
<tr>
<td>
<label for="admin_email"></label>
<input name="admin_email" type="text" id="admin_email" value="<?php echo $row['admin_email']; ?>" /></td>
</tr>
<tr>
<td width="20%"><h3>Edit Account Password</h3></td>
</tr>
<tr>
<td>
<label for="admin_password"></label>
<input name="admin_password" type="password" id="admin_password" value="<?php echo $row['admin_password']; ?>" /></td>
</tr>
<tr>
<td><input type="submit" name="update_account" id="update_account" value="Update Account" /></td>
</tr>
</table>
</form>
<?php
}
?>