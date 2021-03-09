<?php
require_once "session.php";
require_once 'model'.DIRECTORY_SEPARATOR.'functions.php';
if(@isset($_GET['download'])){
	$file = downloadDB();
	header("Content-Description: File Transfer");
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attatchment; filename=backup".time().".sql");
	header("Expires:0");
	header("Content-Length: ".filesize($file));
	echo readfile($file);
	userlog($_COOKIE['user'], "downloaded database", 1);
}
require_once('views'.DS.'header.php');


?>

<h1>Database</h1>

<h2>Backup database</h2>

<a href="db.php?download=true">Download backup</a><br><br>

<h2>Upload database</h2>
<form action="db.php" method="post" enctype="multipart/form-data">
	<input name="file" id="file" type="file" accept=".sql"><br>
	<input name="upload" type="submit" value="Upload">
</form>
<?php
    if (@isset($_POST['upload'])){
        echo uploadDB();
	    userlog($_COOKIE['user'], "uploaded database", 1);
    }
?>


<?php
echo("<br><a href=./>Go back</a><br>");
echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>";
require_once('views'.DS.'footer.php');?>
