<?php require('../functions.php');

if(@isset($_POST['update'])){
    if(updateNotification($_POST['id'], $_POST['name'], $_POST['type'], $_POST['status'])){
        header("Location: ../notifys.php?updatenotify=true");
    } else {
        header("Location: ../notifys.php?updatenotify=false");
    }
}