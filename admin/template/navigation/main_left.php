<?php
if($_SESSION['signed_in'] == false )
?>
<?php
if($_SESSION['admin_level'] == 'Admin')
{ 
?>

<h3><i class="fas fa-bars"></i> Admin Options</h3>
<div id="menu"> 
<li><a href="index.php"><i class='fas fa-home'></i> Home</a></li>
<li><a href="index.php?admin&page=admins" title="Manage Admins"><i class='fas fa-users'></i> Admins</a></li>
<li><a href="index.php?admin&page=backup" title="Backup DB & Website"><i class='fas fa-sync'></i> Backup</a></li>
<li><a href="index.php?admin&page=servers" title="Manage Servers"><i class='fas fa-server'></i> Servers</a></li>
<li><a href="index.php?admin&page=settings" title="Update Site Settings"><i class='fas fa-cogs'></i> Settings</a></li>
<li><a href="index.php?admin&page=updates" title="Check For Updates & View Changelogs"><i class='fas fa-upload'></i> Updates</a></li>
<li><a href="index.php?admin&page=logout"><i class='fas fa-sign-out-alt'></i> Logout</a></li>
</div>
<?php
}
else
{ 
echo("<script>location.href = 'login.php';</script>");
}
?>
</div>