<?php
ob_start();
session_start();
include '../configs/database/database_connect.php';
include '../configs/database/database_settings.php';
if($settings['site_installed'] == '')
{
echo("<script>location.href = '/install/';</script>");
}
else
{ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title><?php echo $settings['site_name'] ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link href="../style.css" rel="stylesheet" type="text/css"/>
<link href="css/dropdown/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="css/dropdown/themes/nvidia.com/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>
.info-msg,
.success-msg,
.warning-msg,
.error-msg {
margin: 0px 0;
border-radius: 3px 3px 3px 3px;
}
.info-msg {
color: #059;
background-color: #BEF;
width: 100%;
float: left;
}
.success-msg {
color: #270;
background-color: #DFF2BF;
}
.warning-msg {
color: #9F6000;
background-color: #FEEFB3;
}
.error-msg {
color: #D8000C;
background-color: #FFBABA;
}
</style>
<!-- / END -->
</head>

<body>
<div id="main">
<?php include 'template/site_header.php'; ?>
<br /> 
<div id="content">
<div class="heading_box"><h3><b><i class="fas fa-lock"></i> <?php echo $settings['site_name']; ?> Admin Login</b></h3></div>
<?php
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
echo '
<p>Hi:' . $_SESSION['admin_username'] . ' You are already Logged in to your account.</p>
';
}
else
{
if($_SERVER['REQUEST_METHOD'] != 'POST')
{ 
?> 

<form id="form1" method="post" action="">
<table width="468" border="0">
<tr>
<td width="126"><p><strong>Admin Email</strong></p></td>
<td width="332"><p>
<input name="admin_email" type="text" required id="admin_email" />
</p>
</td>
</tr>
<tr>
<td><p><strong>Admin Password</strong></p></td>
<td><p>
<input type="password" required name="admin_password" id="admin_password" />
</p>
</td>
</tr>
<tr>
<td><p>&nbsp;</p></td>
<td><p>
<input name="submit" type="submit" class="searchbutton" id="submit" value="Login" /> 
</td>
</tr>
</table>
</form>
<?php 
}
else
{
$errors = array(); 
if(!isset($_POST['admin_email']))
{
$errors[] = 'The Email field must not be empty.';
}
if(!isset($_POST['admin_password']))
{
$errors[] = 'The Password field must not be empty.';
}
if(!empty($errors))
{
echo 'A couple of fields are not filled in correctly.<br /><br />';
echo '<ul>';
foreach($errors as $key => $value)
{
echo '<li>' . $value . '</li>'; 
}
echo '</ul>';
}
else
{
$sql = "SELECT 
admin_id,
admin_username,
admin_email,
admin_datereg,
admin_datelast,
admin_level,
admin_active
FROM
admins
WHERE
admin_email = '" . mysqli_real_escape_string($conn, $_POST['admin_email']) . "'
AND
admin_password = '" . sha1($_POST['admin_password']) . "'
AND
admin_active = '" . mysqli_real_escape_string($conn, 'Active') . "'";
$result = mysqli_query($conn, $sql);
if(!$result)
{
echo '
<p>
<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Something went wrong while logging in. Please try again later.</div>';
}
else
{
if(mysqli_num_rows($result) == 0)
{
echo '
<p>
<div class="error-msg">
<p><i class="fa fa-times-circle"></i>
Account details for '.$_POST['admin_email'].' incorrect please try again.
<br />
<br />
If these details are correct please double check and try again.
</div>';
}
else
{
$_SESSION['signed_in'] = true;
while($row = mysqli_fetch_assoc($result))
{
$_SESSION['admin_id'] = $row['admin_id'];
$_SESSION['admin_username'] = $row['admin_username'];
$_SESSION['admin_email'] 	= $row['admin_email'];
$_SESSION['admin_datereg'] 	= $row['admin_datereg'];
$_SESSION['admin_datelast'] = $row['admin_datelast'];
$_SESSION['admin_level'] = $row['admin_level'];
$_SESSION['admin_active'] = $row['admin_active'];
}
echo("<script>location.href = '/admin/index.php';</script>");

$date = date("d/m/y H:i:s A");
mysqli_query($conn, "Update admins
SET  
admin_datelast = '$date'
WHERE 
admin_id='$_SESSION[admin_id]'");

}
}
}
}
}
?>
<hr/>
<?php include 'template/site_footer.php'; ?>
</div>
</div>
</body>
</html>
<?php
}
?>