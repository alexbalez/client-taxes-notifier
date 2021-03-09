<?php
const DDS = DIRECTORY_SEPARATOR;
require_once('..' . DDS . 'model/functions.php');

if(@isset($_POST['update'])){

	$info = array("company" => $_POST["company"], "bnum" => $_POST['bnum'], "contactfirst" =>  $_POST['contactfirst'],
		"contactlast" => $_POST['contactlast'], "phone" =>  $_POST['phone'], "cell" => $_POST['cell'],
		"website" => $_POST['website'], "id" => $_POST['id']);
	if(@isset($_POST['active'])){
		$info += array("active" => $_POST['active']);
	} else {
		$info += array("active" => 1);
	}

    if(updateClient($_COOKIE['user'], getDB(), $info)){
        header("Location: ..".DS."clients.php?updateclient=true");
        die();
    } else {
        header("Location: ..".DS."clients.php?updateclient=false");
        die();
    }
}


if (@isset($_POST["delete"])){
	$info = array("id" => $_POST["id"]);
	if(deleteClient($_COOKIE['user'], getDB(), $info)){
		header("Location: ..".DS."clients.php?deleteclient=true");
	};
}