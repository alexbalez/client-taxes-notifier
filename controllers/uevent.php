<?php require('../functions.php');

if(@isset($_POST['update'])){
    if(updateEvent($_POST['id'], $_POST['clientid'], $_POST['notifyid'], $_POST['start'], $_POST['freq'], $_POST['status'], $_POST['original'])){
        header("Location: ../events.php?updateevent=true");
    } else {
        header("Location: ../events.php?updateevent=false");
    }
}