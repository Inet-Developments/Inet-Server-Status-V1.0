<?php
ob_start();
session_start();
include 'configs/database/database_connect.php';
include 'configs/database/database_settings.php';
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
<link href="style.css" rel="stylesheet" type="text/css"/>
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
<?php include 'admin/template/site_header.php'; ?>
<br /> 
<div id="content">
<?php
$page = @$_GET['page'];

if($page == "error"){
include"includes/template/404.php";
}
else{ include"main.php";
}
?>
<hr/>
<?php include 'admin/template/site_footer.php'; ?>
</div>
</div>
</body>
</html>
<?php
}
?>