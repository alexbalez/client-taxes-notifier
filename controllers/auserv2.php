<?php
require_once('..' . DIRECTORY_SEPARATOR. 'model'.DIRECTORY_SEPARATOR.'functions.php');

if(@isset($_POST['add'])){
	$info = (array("first" => $_POST['first'], "last" => $_POST['last'],
		"email" => $_POST['email'], "cell" => $_POST['cell'], "pos" => $_POST['pos'],
		"uname" => $_POST['uname'], "pw" => sha1($_POST['pw']), "status" => $_POST['status']));

	$file =  DS."pics". DS . basename($_FILES["file"]["name"]);
	$filetype = strtolower(pathinfo($file, PATHINFO_EXTENSION));

	if(@isset($_POST['submit'])){
		try{
			if (@!getimagesize($_FILES["file"]["tmp_name"])){
				header("Location: ..".DS."users.php?adduser=false");
			}
		} catch (Exception $e){
			header("Location: ..".DS."users.php?adduser=false");

		}
	}

	if($filetype != "gif" && $filetype != "jpg" && $filetype != "jpeg" && $filetype != "png"){
		return "Incorrect file type. Must be gif/jpg/png.";
	}

	if(move_uploaded_file($_FILES["file"]["tmp_name"], getcwd().$file)) {
		#echo "File $file uploaded.";
	}


	$info += array("filename" => $_FILES["file"]["name"]);

	if(addUser($_COOKIE['user'], getDB(), $info)){
		header("Location: ..".DS."users.php?adduser=true");
	} else {
		header("Location: ..".DS."users.php?adduser=false");
	}
}

if(@isset($_POST['update'])){

	$info = array( "first" =>  $_POST['first'],
		"last" => $_POST['last'],  "cell" => $_POST['cell'],
		 "id" => $_POST['id'], "email" => $_POST['email'], "pos" => $_POST['pos'],
		"uname" => $_POST['uname'], "pw" => $_POST['pw'], "status"=>$_POST['status'],
		"filename" => $_POST['filename'], "deleted", $_POST['deleted']);

    if(updateUser($_COOKIE['user'], getDB(), $info)){
        header("Location: ..".DS."users.php?updateuser=true");
        die();
    } else {
        header("Location: ..".DS."users.php?updateuser=false");
        die();
    }
}


if (@isset($_POST["delete"])){
	$info = array("id" => $_POST["id"]);
	if(deleteUser($_COOKIE['user'], getDB(), $info)){
		header("Location: ..".DS."users.php?deleteuser=true");
	};
}