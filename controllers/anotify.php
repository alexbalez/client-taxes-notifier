<?php require('../functions.php');


if(isset($_POST['add'])){

    if (!isset($_POST['status'])){
        #status wasn't included, use default
        if(!addNotification($_POST['name'], $_POST['type'], 1)){
            header("Location: ../notifys.php?addnotify=false");
        } else {
            header("Location: ../notifys.php?addnotify=true");
        }
    } else {
        if (!addNotification($_POST['name'], $_POST['type'], $_POST['status'])){
            header("Location: ../notifys.php?addnotify=false");
        } else {
            header("Location: ../notifys.php?addnotify=true");
        }
    }
}