<?php

require_once "session.php";
require_once "model".DIRECTORY_SEPARATOR."functions.php";
if(@isset($_POST['user'])){
	setcookie("user", $_POST['user']);
}
    # load different parts of the page depending on which was chosen in the select box
    $choice = '';
    if(@isset($_GET['choice'])){
        $choice = $_GET['choice'];
        if($choice == 'clients'){
            header('Location: .'.DS.'clients.php');
            die();
        } else if ($choice == 'events'){
            header('Location: .'.DS.'events.php');
            die();
        } else if ($choice == 'notifys'){
            header('Location: .'.DS.'notifys.php');
            die();
        } else if ($choice == 'users') {
	        header('Location: .' . DS . 'users.php');
	        die();
        }else if ($choice == 'db'){
		        header('Location: .'.DS.'db.php');
		        die();
        } else {
            #shouldn't ever really reach here unless someone modifies the select box manually
            echo("Invalid choice.");
            require('.'.DS.'views'.DS.'index.php');
        }
    } else {
        # load the select box if there wasn't anything posted? might need to modify later if i decide to forward to other page
        require('.'.DS.'views'.DS.'index.php');
    }

     echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; 
require('.'.DS.'views'.DS.'footer.php'); ?>