<?php
//check if user if signed in
if($_SESSION['signed_in'] == true)
{
//unset all variables
$_SESSION['signed_in'] = NULL;
$_SESSION['admin_id']   = NULL;
$_SESSION['admin_username'] = NULL;
$_SESSION['admin_email'] 	 = NULL;
$_SESSION['admin_datereg'] 	 = NULL;
$_SESSION['admin_datelast']  = NULL;
$_SESSION['admin_level']  = NULL;
$_SESSION['admin_active']  = NULL;

echo("<script>location.href = '/admin/index.php';</script>");
}
else
{
echo("<script>location.href = '/admin/login.php';</script>");
}
?>	