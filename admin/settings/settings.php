<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin')
{
echo("<script>location.href = 'login.php';</script>");
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
<h3><i class="fas fa-cogs"></i> <b><?php echo $settings['site_name'] ?> Site Settings</b></h3></div>
<?php
$postData = $statusMsg = '<div class="info-msg">
<p><i class="fa fa-info-circle"></i> Edit your site settings.</p></div>';  
if (isset($_POST['update_settings'])) 
{  

if(!empty($_POST['site_name']))	

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$site_name = $_POST['site_name'];

$sql = "UPDATE settings
SET 
site_name = '$site_name'
";

if (mysqli_query($conn, $sql)) {
$status = 'success'; 
$statusMsg = '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Site Settings Updated.</div>'; 
$postData = '';
} else {
echo "<i class='fa fa-times-circle'></i> Error Settings could not be updated.: " . mysqli_error($conn);
}
}
?>
<?php if(!empty($statusMsg)){ ?>
<p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
<?php } ?>
<form name="form1" method="post" action="">
<table width="100%" border="0">
<tr>
<td width="20%"><h3>Site Name</h3></td>
</tr>
<tr>
<td>
<label for="site_name"></label>
<input name="site_name" type="text" id="site_name" value="<?php echo $settings['site_name']; ?>" /></td>
</tr>
<tr>
<td>
<input type="submit" name="update_settings" id="update_settings" value="Update Settings" /></td>
</tr>
</table>
</form>
<?php
}
?>