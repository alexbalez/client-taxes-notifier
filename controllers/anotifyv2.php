<?php require('..'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'functions.php');


if(isset($_POST['add'])){

	$info = array("named" => $_POST['named'], "types" => $_POST['types']);

	if(@isset($_POST['status'])){
		$info += array("status" => $_POST['status']);
	} else{
		$info += array("status" => 1);
	}
	if (!addNotification($_COOKIE['user'], getDB(), $info)){
		header("Location: ../notifys.php?addnotify=false");
	} else {
		header("Location: ../notifys.php?addnotify=true");
	}


}