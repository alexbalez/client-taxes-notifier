<?php require('../model/functions.php');


if(isset($_POST['add'])){

	$info = array( "clientid" => $_POST['clientid'],
	"notifid" => $_POST['notifyid'],
	"start" => $_POST['start'],
	"freq" => $_POST['freq']);


	if(@isset($_POST['status'])){
		$info += array("active" => $_POST['status']);
	} else{
		$info += array("active" => 1);
	}

	if(addEvent($_COOKIE['user'], getDB(), $info)){
		header("Location: ../events.php?addevent=true");
	} else {
		header("Location: ../events.php?addevent=false");
	}
}