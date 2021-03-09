<?php require('../functions.php');


if(isset($_POST['add'])){

    if (!isset($_POST['status'])){
        #status wasn't included, use default
        if(!addClient($_POST['company'], $_POST['bnum'], $_POST['contactfirst'], $_POST['contactlast'], $_POST['phone'], $_POST['cell'], $_POST['website'], 1)){
            header("Location: ../clients.php?addclient=false");
        } else {
            header("Location: ../clients.php?addclient=true");
        }
    } else {
        if (!addClient($_POST['company'], $_POST['bnum'], $_POST['contactfirst'], $_POST['contactlast'], $_POST['phone'], $_POST['cell'], $_POST['website'], $_POST['status'])){
            header("Location: ../clients.php?addclient=false");
        } else {
            header("Location: ../clients.php?addclient=true");
        }
    }
}