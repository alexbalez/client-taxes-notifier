<?php require('../functions.php');


if(isset($_POST['add'])){
    
    if (!isset($_POST['status'])){
        #status wasn't included, use default
        if(!addEvent($_POST['clientid'], $_POST['notifyid'], $_POST['start'], $_POST['freq'], 1)){
            header("Location: ../events.php?addevent=false");
        } else {
            header("Location: ../events.php?addevent=true");
        }
    } else {
        if (!addEvent($_POST['clientid'], $_POST['notifyid'], $_POST['start'], $_POST['freq'], $_POST['status'])){
            header("Location: ../events.php?addevent=false");
        } else {
            header("Location: ../events.php?addevent=true");
        }
    }
}