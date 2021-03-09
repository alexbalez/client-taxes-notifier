<?php require('../model/functions.php');


if(@isset($_POST['update'])){
	$info = array( "clientid" => $_POST['clientid'],
		"notifid" => $_POST['notifid'],
		"start" => $_POST['start'],
		"freq" => $_POST['freq'],
		"id" => $_POST['id'],
		"status" => $_POST['status']);


	if(@isset($_POST['status'])){
		$info += array("status" => $_POST['status']);
	} else{
		$info += array("status" => 1);
	}

	if(updateEvent($_COOKIE['user'], getDB(), $info)){
		header("Location: ..".DS."events.php?updateevent=true");
		die();
	} else {
		header("Location: ..".DS."events.php?updateevent=false");
		die();
	}

}

if (@isset($_POST["delete"])){
	$info = array("id" => $_POST["id"]);
	if(deleteEvent($_COOKIE['user'], getDB(), $info)){
		header("Location: ..".DS."events.php?deleteevent=true");
	};
}