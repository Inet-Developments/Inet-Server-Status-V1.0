<?php
include '../configs/database/database_connect.php';
include '../configs/database/database_settings.php';
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin')
{
echo("<script>location.href = '../login.php';</script>");
}
else
{ 
?>
<div class="heading_box">
<h3><i class="fas fa-sync"></i> <b><?php echo $settings['site_name'] ?> Backup</b></h3></div>
<p>This is the backup area where you can backup your entire Database and Website for download.</p>

<div class="heading_box">
<h3><i class="fas fa-sync"></i> <b><?php echo $settings['site_name'] ?> Database Backup</b></h3></div>
<?php
$postData = $statusMsg = '<div class="info-msg">
<p><i class="fa fa-info-circle"></i> This will backup your entire '.$settings['site_name'].' Database.</p></div>';  

// If form submitted
if(isset($_POST['db_backup'])){ 

$postData = $_POST; 
   
$conn = mysqli_connect("".$database_server."","".$database_username."","".$database_password."","".$database_name."");
$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_row($result)) {
$tables[] = $row[0];
}
$sqlScript = "";
foreach ($tables as $table) {
$query = "SHOW CREATE TABLE $table";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$sqlScript .= "\n\n" . $row[1] . ";\n\n";
$query = "SELECT * FROM $table";
$result = mysqli_query($conn, $query);
$columnCount = mysqli_num_fields($result);
for ($i = 0; $i < $columnCount; $i ++) {
while ($row = mysqli_fetch_row($result)) {
$sqlScript .= "INSERT INTO $table VALUES(";
for ($j = 0; $j < $columnCount; $j ++) {
$row[$j] = $row[$j];           
if (isset($row[$j])) {
$sqlScript .= '"' . mysqli_real_escape_string($conn,$row[$j]) . '"';
} else {
$sqlScript .= '""';
}
if ($j < ($columnCount - 1)) {
$sqlScript .= ',';
}
}
$sqlScript .= ");\n";
}
}   
$sqlScript .= "\n"; 
}
if(!empty($sqlScript))
{
$date = date('d-m-y-H-i-s', time()); 
$backup_file_name =  '../'.$settings['site_name'].'-'.$date.'.sql';
$fileHandler = fopen($backup_file_name, 'w+');
$number_of_lines = fwrite($fileHandler, $sqlScript);
fclose($fileHandler);
}

$status = 'success'; 
$statusMsg = '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Database Backup complete and can be found at: '.$_SERVER['DOCUMENT_ROOT'].' <a href="../'.$backup_file_name.'" title="Download">Download Backup</a></div>'; 
$postData = '';

}
?>

<?php if(!empty($statusMsg)){ ?>
<p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
<?php } ?>
<form id="form1" name="form1" method="post">
  <input type="submit" name="db_backup" id="db_backup" value="Backup Database">
</form>

<div class="heading_box">
<h3><i class="fas fa-sync"></i> <b><?php echo $settings['site_name'] ?> Website Backup</b></h3></div>
<?php
$postData = $statusMsg = '<div class="info-msg">
<p><i class="fa fa-info-circle"></i> This will backup your entire '.$settings['site_name'].' Website.</p></div>';  

// If form submitted
if(isset($_POST['web_backup'])){ 

$postData = $_POST; 

function zip_folder ($input_folder, $output_zip_file) {
$zipClass = new ZipArchive();
$input_folder = realpath($input_folder);
$addDirDo = static function($input_folder, $name) use ($zipClass, & $addDirDo ) {
$name .= '/';
$input_folder .= '/';
$dir = opendir ($input_folder);
while ($item = readdir($dir))    {
if ($item == '.' || $item == '..') continue;
$itemPath = $input_folder . $item;
if (filetype($itemPath) == 'dir') {
$zipClass->addEmptyDir($name . $item);
$addDirDo($input_folder . $item, $name . $item);
} else {
$zipClass->addFile($itemPath, $name . $item);
}
}
};
if($input_folder !== false && $output_zip_file !== false)
{
$res = $zipClass->open($output_zip_file, \ZipArchive::CREATE);
if($res === true)   {
$zipClass->addEmptyDir(basename($input_folder));
$addDirDo($input_folder, basename($input_folder));
$zipClass->close(); 
}
else   { exit ('Could not create a zip archive, migth be write permissions or other reason.'); }
}
}
$date = date('d-m-y-H-i-s', time()); 
zip_folder(''.$_SERVER['DOCUMENT_ROOT'].'',    ''.$_SERVER['DOCUMENT_ROOT'].'/'.$settings['site_name'].'-'.$date.'.zip') ;

$status = 'success'; 
$statusMsg = '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Website Backup complete and can be found at: '.$_SERVER['DOCUMENT_ROOT'].' <a href="../'.$settings['site_name'].'-'.$date.'.zip" title="Download">Download Backup</a></div>'; 
$postData = '';

}
?>
<?php if(!empty($statusMsg)){ ?>
<p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
<?php } ?>
<form id="form1" name="form1" method="post">
 <input type="submit" name="web_backup" id="web_backup" value="Backup Website">
</form>
<?php
}
?>