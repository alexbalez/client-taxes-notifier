<?php

$s="";
require_once "model".DIRECTORY_SEPARATOR."functions.php";
if(@isset($_POST['submit'])){
	if(authUser($_POST['user'], $_POST['password'])){
		setcookie("user", $_POST['user']);
		header("Location: .".DS."index.php");
	} else {
		$s="Invalid user.";
	}
}

require_once "views".DIRECTORY_SEPARATOR."header.php";
?>

<h1>Login</h1>
<form action="./login.php" method="post">
    User: <input type="text" name="user" value="admin"><br>
    Password: <input type="password" name="password" value="password"><br>
    <input type="submit" name="submit" value="Log in">
</form>

<?php


echo $s;
echo @isset($_GET['expired']) ? '<span style="color:red">Your previous session expired. Please log in again.</span>':"";
userlog($_SERVER['REMOTE_ADDR'], "session expired", 1);


include "views".DS."footer.php";
?>