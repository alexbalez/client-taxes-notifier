<?php require('..'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'functions.php');

if(@isset($_POST['update'])){
	$info = array("id" => $_POST["id"],
		"named" => $_POST["named"],
		"types" => $_POST["types"],
		"status" => $_POST["status"]);

    if(updateNotification($_COOKIE['user'], getDB(), $info)){
        header("Location: ../notifys.php?updatenotify=true");
    } else {
        header("Location: ../notifys.php?updatenotify=false");
    }
}

if (@isset($_POST["delete"])){
	$info = array("id" => $_POST["id"]);
	if(deleteNotification($_COOKIE['user'], getDB(), $info)){
		header("Location: ..".DS."notifys.php?deletenotify=true");
	};
}