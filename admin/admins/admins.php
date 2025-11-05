<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin')
{
echo("<script>location.href = '../login.php';</script>");
}
else
{ 
?>
<div class="heading_box">
<h3><i class="fas fa-users"></i> <b><?php echo $settings['site_name'] ?> Admins</b></h3></div>
<?php
$postData = $statusMsg = '<div class="info-msg">
<p><i class="fa fa-info-circle"></i> Create a new Admin Member</p></div>';  

// If form submitted
if(isset($_POST['add_admin']))
{ 

$postData = $_POST; 

// Validate form fields 
if(!empty($_POST['admin_username']) 
&& 
!empty($_POST['admin_email'])
&&
!empty($_POST['admin_role'])
&&
!empty($_POST['admin_active']))
				
$admin_username = $_POST['admin_username'];
$passwordchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
$password = substr( str_shuffle( $passwordchars ), 0, 8 );
$admin_password = sha1($password); 
$admin_email = $_POST['admin_email'];
$admin_role = $_POST['admin_role'];
$admin_active = $_POST['admin_active'];
$admin_datereg = date("d/m/y H:i:s A");	

// Check Admin is not duplicate.
$select = mysqli_query($conn, "SELECT `admin_username` FROM admins WHERE `admin_username` = '".$_POST['admin_username']."'") or exit(mysqli_error($conn));
if(mysqli_num_rows($select)) {
exit ('<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Admin Username '.$admin_username.' exists and has already been created. <a href="index.php?admin&page=admins">Please create another</a>.</div>');
}

if(!filter_var($_POST['admin_email'], FILTER_VALIDATE_EMAIL)) {
exit ('<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Invalid Email Address. <a href="index.php?admins&page=admins">Please Try Again</a>.</div>');
}

// Check Email is not duplicate.
$select = mysqli_query($conn, "SELECT `admin_email` FROM admins WHERE `admin_email` = '".$_POST['admin_email']."'") or exit(mysqli_error($conn));
if(mysqli_num_rows($select)) {
exit ('<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Admin Email '.$admin_email.' exists and has already been created. <a href="index.php?admin&page=admins">Please create another</a>.</div>');
}

// Insert into database
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

	
$sql = mysqli_query ($conn, "INSERT INTO admins 
(admin_username, 
admin_password, 
admin_email,
admin_datereg,
admin_datelast,
admin_level,
admin_active)

VALUES 
('" . mysqli_real_escape_string($conn, $_POST['admin_username']) . "', 
'" . mysqli_real_escape_string($conn, $admin_password) . "',
'" . mysqli_real_escape_string($conn, $_POST['admin_email']) . "', 
'" . mysqli_real_escape_string($conn, $admin_datereg) . "',
'" . mysqli_real_escape_string($conn, 'No Previous Login') . "',
'" . mysqli_real_escape_string($conn, 'Admin') . "',
'" . mysqli_real_escape_string($conn, $_POST['admin_active']) . "')");
	
// If database connection is valid
if ($conn) {

$to      = ''.$admin_email.''; 
$subject = ''.$settings['site_name'].' New Account Details'; 
$message = '

Thank You, '.$admin_username.', your account has been created at '.$settings['site_name'].',
Your account details are below:

------------------------
Admin Username: '.$admin_username.'
Admin Password: '.$password.'
Admin Email Address: '.$admin_email.'
Admin Level: '.$admin_level.'
Admin Creation Date: '.$admin_datereg.'
------------------------
					
Please login at: 
https://'.$_SERVER['SERVER_NAME'].'/index.php?admin&page=login&admin_username='.$admin_username.'&admin_password='.$password.'
					
Please keep this email safe for your records.'; 
					
$headers = 'From:'.$settings['site_email'].'' . "\r\n"; 
mail($to, $subject, $message, $headers); 	

$status = 'success'; 
$statusMsg = '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Admin '.$_POST['admin_username'].' created and is Active..</p></div>'; 
} 
else 
{
$status = 'error';
$statusMsg = '<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Error creating new Admin '.$_POST['admin_username'].'.</p>';
}
}
?>

<?php if(!empty($statusMsg)){ ?>
<p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
<?php } ?>
<form name="form1" method="post" action="">
<table width="100%" border="0">
<tr>
<td width="20%"><h3>Account Username</h3></td>
</tr>
<tr>
<td>
<label for="admin_username"></label>
<input type="text" name="admin_username" id="admin_username" /></td>
</tr>
<tr>
<td><h3>Account Email Address</h3></td>
</tr>
<tr>
<td><label for="admin_email"></label>
<input type="text" name="admin_email" id="admin_email" /> 
(Must be valid as  account password will be sent by email)</td>
</tr>
<tr>
<td><h3>Account Status</h3></td>
</tr>
<tr>
<td>
<select name="admin_active" id="admin_active">
<option value="Active" selected="selected">Active</option>
<option value="Inactive">Inactive</option>
</select>
    Account is Active or Inactive</td>
</tr>
<tr>
<td>
<input type="submit" name="add_admin" id="add_admin" value="Add Account" /></td>
</tr>
</table>
</form>

<hr />
<div class="heading_box">
<h3><i class="fas fa-cog"></i> <b>Manage <?php echo $settings['site_name'] ?> Admin Accounts</b></h3></div>

<?php
$result = mysqli_query($conn, "SELECT * FROM admins WHERE admin_level = 'Admin' ORDER BY admin_username ASC") 
or die(mysqli_error($conn));  
$numrows = mysqli_num_rows($result);
if($numrows == 0){ 
echo "You currently have no Admin Accounts in the database."; 
} 
else
{
echo "<table border='0' cellpadding='3' table width='100%'>";
echo "<tr td align='left'> <th><p>Admin Name</p></th> <th><p>Admin Email</p></th> <th><p>Admin Level</p></th> <th><p>Status</p></th> <th><p>Edit</p></th> <th><p>Delete</p></th></tr>";
while($row = mysqli_fetch_array( $result )) {
echo "<tr>";
echo '<td align="left" valign="top"><p>' . $row['admin_username'] . '</p></td>';
echo '<td align="left" valign="top"><p>' . $row['admin_email'] . '</p></td>';
echo '<td align="left" valign="top"><p>' . $row['admin_level'] . '</p></td>';
echo '<td align="left" valign="top"><p>' . $row['admin_active'] . '</p></td>';
echo '<td align="left" valign="top"><p><a href="index.php?admin&page=admins_edit&admin_id=' . $row['admin_id'] . '"><i class="fas fa-edit"></i></a></p></td>';
echo '<td align="left" valign="top"><p><a href="index.php?admin&page=admins_delete&admin_id=' . $row['admin_id'] . '"><i class="fas fa-trash-alt"></i></a></p></td>';
echo "</tr>"; 
} 
echo "</table>";
}
?>
<?php
}
?>