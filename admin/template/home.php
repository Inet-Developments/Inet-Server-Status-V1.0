<?php
if(is_dir("install/"))
{
echo "<span style='color:red;'>
<i class='fa fa-times-circle'></i> Install Folder Detected please delete it for security reasons.
</span>";
}
?>
<h3><i class="fas fa-home"></i> Welcome To <?php echo $settings['site_name'] ?> Admin Panel.</h3>
<p>This is where you can administer your Servers Status, monitor activity and manage all other aspects</p>