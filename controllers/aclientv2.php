<?php require('../model/functions.php');


if(isset($_POST['add'])){
	$info = array("company" => $_POST["company"], "bnum" => $_POST['bnum'], "contactfirst" =>  $_POST['contactfirst'],
		"contactlast" => $_POST['contactlast'], "phone" =>  $_POST['phone'], "cell" => $_POST['cell'],
		"website" => $_POST['website']);
	if(@isset($_POST['active'])){
		$info += array("active" => $_POST['active']);
	} else{
		$info += array("active" => 1);
	}

	if (!addClient($_COOKIE['user'], getDB(), $info)){
		header("Location: ../clients.php?addclient=false");
	} else {
		header("Location: ../clients.php?addclient=true");
	}
}
